<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\EmailController;
use App\Models\Streamer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class StreamerReferencesController extends Controller
{

    private function getTwitchAccessToken()
    {
        $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to get Twitch access token');
    }

    public function all()
    {
        $streamers = DB::table('webhook_streamers')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.streamer_references.all', compact('streamers'));
    }

    public function getUpdatedStreamerReferences()
    {
        $streamers = DB::table('webhook_streamers')->orderByDesc('created_at')->get();

        $html = view('partials.streamer_table_rows', compact('streamers'))->render();

        return response()->json(['html' => $html]);
    }

    public function addStreamerReference(Request $request)
    {
        $request->validate(['username' => 'required|string']);
        $username = $request->input('username');

        try {
            $clientId = env('TWITCH_CLIENT_ID');
            $clientSecret = env('TWITCH_CLIENT_SECRET');

            // Obter token de acesso
            $authResponse = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            $accessToken = $authResponse['access_token'];

            // Buscar dados do usuário
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Client-Id' => $clientId,
            ])->get('https://api.twitch.tv/helix/users', [
                'login' => $username,
            ]);

            $twitchUser = $userResponse['data'][0];
            $twitchUserId = $twitchUser['id'];
            $displayName = $twitchUser['display_name'];
            $profileImage = $twitchUser['profile_image_url'];

            $callback = 'https://stream.ravenor.online/twitch-webhook';
            $secret = env('TWITCH_WEBHOOK_SECRET', 'seu_segredo');

            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Client-Id' => $clientId,
                'Content-Type' => 'application/json',
            ];

            // Criar webhook para stream.online
            $onlineWebhook = Http::withHeaders($headers)->post('https://api.twitch.tv/helix/eventsub/subscriptions', [
                'type' => 'stream.online',
                'version' => '1',
                'condition' => [
                    'broadcaster_user_id' => $twitchUserId,
                ],
                'transport' => [
                    'method' => 'webhook',
                    'callback' => $callback,
                    'secret' => $secret,
                ]
            ]);

            $onlineSubscriptionId = $onlineWebhook['data'][0]['id'] ?? null;
            Log::info('Webhook stream.online criado', $onlineWebhook->json());

            // Criar webhook para stream.offline
            $offlineWebhook = Http::withHeaders($headers)->post('https://api.twitch.tv/helix/eventsub/subscriptions', [
                'type' => 'stream.offline',
                'version' => '1',
                'condition' => [
                    'broadcaster_user_id' => $twitchUserId,
                ],
                'transport' => [
                    'method' => 'webhook',
                    'callback' => $callback,
                    'secret' => $secret,
                ]
            ]);

            $offlineSubscriptionId = $offlineWebhook['data'][0]['id'] ?? null;
            Log::info('Webhook stream.offline criado', $offlineWebhook->json());

            // Criar webhook para channel.update (mudança de título, categoria, etc.)
            $updateWebhook = Http::withHeaders($headers)->post('https://api.twitch.tv/helix/eventsub/subscriptions', [
                'type' => 'channel.update',
                'version' => '2',
                'condition' => [
                    'broadcaster_user_id' => $twitchUserId,
                ],
                'transport' => [
                    'method' => 'webhook',
                    'callback' => $callback,
                    'secret' => $secret,
                ]
            ]);

            $updateSubscriptionId = $updateWebhook['data'][0]['id'] ?? null;
            Log::info('Webhook channel.update criado', $updateWebhook->json());

            // Salvar no banco
            DB::table('webhook_streamers')->insert([
                'username' => $username,
                'twitch_user_id' => $twitchUserId,
                'display_name' => $displayName,
                'profile_image_url' => $profileImage,
                'subscription_online_id' => $onlineSubscriptionId,
                'subscription_offline_id' => $offlineSubscriptionId,
                'subscription_update_id' => $updateSubscriptionId,
                'is_contracted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Streamer adicionado. Webhooks stream.online, stream.offline e channel.update criados.'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao adicionar streamer e criar webhooks', ['exception' => $e]);
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function removeStreamerReferenceById($id)
    {
        $clientId = env('TWITCH_CLIENT_ID');
        $clientSecret = env('TWITCH_CLIENT_SECRET');

        $streamer = DB::table('webhook_streamers')->where('id', $id)->first();

        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }

        $authResponse = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        if (!$authResponse->ok()) {
            return response()->json(['message' => 'Erro ao obter token OAuth'], 500);
        }

        $accessToken = $authResponse->json()['access_token'];

        $headers = [
            'Client-ID' => $clientId,
            'Authorization' => "Bearer $accessToken",
        ];

        try {
            if (!empty($streamer->subscription_online_id)) {
                $responseOnline = Http::withHeaders($headers)
                    ->delete('https://api.twitch.tv/helix/eventsub/subscriptions?id=' . $streamer->subscription_online_id);

                Log::info('Delete stream.online webhook response:', $responseOnline->json() ?? []);

                if (!$responseOnline->successful()) {
                    Log::error('Falha ao deletar webhook online', ['response' => $responseOnline->body()]);
                    return response()->json(['message' => 'Falha ao deletar webhook online'], 500);
                }
            }

            if (!empty($streamer->subscription_offline_id)) {
                $responseOffline = Http::withHeaders($headers)
                    ->delete('https://api.twitch.tv/helix/eventsub/subscriptions?id=' . $streamer->subscription_offline_id);

                Log::info('Delete stream.offline webhook response:', $responseOffline->json() ?? []);

                if (!$responseOffline->successful()) {
                    Log::error('Falha ao deletar webhook offline', ['response' => $responseOffline->body()]);
                    return response()->json(['message' => 'Falha ao deletar webhook offline'], 500);
                }
            }

            if (!empty($streamer->subscription_update_id)) {
                $responseUpdate = Http::withHeaders($headers)
                    ->delete('https://api.twitch.tv/helix/eventsub/subscriptions?id=' . $streamer->subscription_update_id);

                Log::info('Delete channel.update webhook response:', $responseUpdate->json() ?? []);

                if (!$responseUpdate->successful()) {
                    Log::error('Falha ao deletar webhook channel.update', ['response' => $responseUpdate->body()]);
                    return response()->json(['message' => 'Falha ao deletar webhook channel.update'], 500);
                }
            }

            // Se chegou aqui, removo do DB
            DB::table('webhook_streamers')->where('id', $id)->delete();

            return response()->json(['message' => 'Streamer removido e webhooks (online/offline/update) cancelados com sucesso!']);
        } catch (\Exception $e) {
            Log::error('Erro ao remover streamer e webhooks', ['exception' => $e]);
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    //

    public function index()
    {
        $streamerReferences = DB::table('streamer_references')
            ->join('streamers', 'streamer_references.streamer_id', '=', 'streamers.id') 
            ->select('streamer_references.streamer_id', DB::raw('count(*) as count'), 'streamers.chave_pix')
            ->where('streamer_references.status', 'paid')
            ->groupBy('streamer_references.streamer_id', 'streamers.chave_pix') 
            ->get();
    
        $streamersDetails = DB::table('streamer_references')
            ->where('status', 'paid')
            ->get();
    
        $orderPrices = DB::table('web_order_histories')
            ->select('session_id', DB::raw('SUM(price) as total_price'))
            ->where('status', 'paid')
            ->groupBy('session_id')
            ->get()
            ->pluck('total_price', 'session_id')
            ->toArray();

        $streamers = DB::table('streamers')->get();

        $pendingApprovals = DB::table('streamers')
        ->where(function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->whereNotNull('temp_coupon_code') 
                         ->where('coupon_approved', 0);
            })
            ->orWhere('chave_pix_approved', 0);
        })
        ->get();
    
        return view('admin.streamer_references.index', compact('streamerReferences', 'streamersDetails', 'orderPrices', 'streamers', 'pendingApprovals'));
    }    

    public function updateStatus(Request $request) {
        $orderId = $request->input('order_id');
        $bonusValue = $request->input('value'); 

        $updatedRows = DB::table('streamer_references')
            ->where('order_id', $orderId)
            ->update([
                'status' => 'delivered',
                'value' => $bonusValue 
            ]);
    
        return response()->json(['success' => $updatedRows > 0]);
    }
    
    
    public function getUpdatedData(Request $request)
    {

        $streamerReferences = DB::table('streamer_references')
            ->join('streamers', 'streamer_references.streamer_id', '=', 'streamers.id')
            ->select(
                'streamers.name as streamerName', 
                'streamer_references.id',
                'streamer_references.order_id', 
                'streamer_references.account_id', 
                DB::raw('count(streamer_references.id) as count'),
                'streamers.chave_pix'
            )
            ->where('streamer_references.status', 'paid')
            ->groupBy('streamers.name', 'streamer_references.id', 'streamer_references.order_id', 'streamer_references.account_id', 'streamers.chave_pix')
            ->get();
    
        $streamersDetails = DB::table('streamer_references')
            ->where('status', 'paid')
            ->get();
    
        $orderPrices = DB::table('web_order_histories')
            ->select('session_id', DB::raw('SUM(price) as total_price'))
            ->where('status', 'paid')
            ->groupBy('session_id')
            ->get()
            ->pluck('total_price', 'session_id')
            ->toArray();
    
        $data = [
            'streamerReferences' => $streamerReferences,
            'streamersDetails' => $streamersDetails,
            'orderPrices' => $orderPrices,
        ];
    
        return response()->json($data);
    }

    public function submitAllReferences(Request $request) {
        $references = $request->input('references');
    
        if (empty($references)) {
            return response()->json(['success' => false, 'message' => 'Nenhuma referência válida enviada.']);
        }
    
        $updatedRows = 0;
    
        foreach ($references as $reference) {
            $updatedRows += DB::table('streamer_references')
                ->where('order_id', $reference['order_id'])
                ->where('status', 'paid')
                ->update([
                    'status' => 'delivered',
                    'value' => $reference['value']
                ]);
        }
    
        return response()->json(['success' => $updatedRows > 0]);
    }    
    
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:streamers,email',
            'url' => 'required|url',
            'pix_key' => 'required|string|unique:streamers,chave_pix',
        ]);

        $streamCode = strtoupper(Str::random(10));

        DB::table('streamers')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'url' => $request->input('url'),
            'chave_pix' => $request->input('pix_key'),
            'chave_pix_approved' => 1,
            'code' => $streamCode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $emailController = new EmailController();
        $response = $emailController->registerStreamer(
            $request->input('email'),
            $streamCode,
            'https://ravenor.online/confirm?token=example_token',
            $request->input('name')
        );
        
        return redirect()->back()->with('success', 'Streamer cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $streamer = Streamer::find($id);

        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }

        $emailController = new EmailController();
        $response = $emailController->deleteStreamer(
            $streamer->email, 
            'testUser',  
            'https://ravenor.online/confirm?token=example_token',
            $streamer->name 
        );

        $streamer->delete();

        return response()->json(['message' => 'Streamer deletado com sucesso']);
    }

    public function approveCoupon($id)
    {
        $streamer = Streamer::find($id);
        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }

        if ($streamer->temp_coupon_code) {
            $streamer->coupon_code = $streamer->temp_coupon_code;
            $streamer->temp_coupon_code = null; 
        }
    
        $streamer->coupon_approved = 1;
        $streamer->save();
    
        return response()->json(['message' => 'Cupom aprovado com sucesso!']);
    }
    
    public function rejectCoupon($id)
    {
        $streamer = Streamer::find($id);
        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }
    
        if ($streamer->temp_coupon_code) {
            $streamer->temp_coupon_code = null;
        }
    
        $streamer->coupon_approved = 1;
        $streamer->save();
    
        return response()->json(['message' => 'Cupom rejeitado com sucesso!']);
    }
    
    
    public function approvePix($id)
    {
        $streamer = Streamer::find($id);
        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }
    
        if (!$streamer->temp_pix_key) {
            return response()->json(['message' => 'Nenhuma chave Pix pendente para aprovação'], 400);
        }

        $streamer->chave_pix = $streamer->temp_pix_key;
        $streamer->chave_pix_approved = 1;
        $streamer->temp_pix_key = null; 
        $streamer->save();
    
        return response()->json(['message' => 'Chave Pix aprovada com sucesso!']);
    }    
    
    public function rejectPix($id)
    {
        $streamer = Streamer::find($id);
        if (!$streamer) {
            return response()->json(['message' => 'Streamer não encontrado'], 404);
        }
    
        if (!$streamer->temp_pix_key) {
            return response()->json(['message' => 'Nenhuma chave Pix pendente para rejeição'], 400);
        }

        $streamer->temp_pix_key = null;
        $streamer->chave_pix_approved = 1;
        $streamer->save();
    
        return response()->json(['message' => 'Chave Pix rejeitada com sucesso!']);
    }

    public function updateCouponDiscount(Request $request)
    {
        $request->validate([
            'coupon_discount' => 'required|numeric|min:0|max:100',
        ]);

        DB::table('server_config')->updateOrInsert(
            ['config' => 'coupon_discount'], 
            ['value' => $request->coupon_discount] 
        );
    
        return response()->json(['message' => 'Desconto atualizado com sucesso!']);
    }
    
    public function getCurrentDiscount()
    {

        $discount = DB::table('server_config')
        ->where('config', 'coupon_discount')
        ->value('value');

        if (!$discount) {
            $discount = 0;  
        }
    
        return response()->json(['discount' => $discount]);
    }
    
}
