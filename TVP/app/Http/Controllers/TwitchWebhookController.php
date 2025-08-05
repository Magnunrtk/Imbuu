<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TwitchWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $messageType = $request->header('Twitch-Eventsub-Message-Type');

        // 1️⃣ Verificação de challenge
        if ($messageType === 'webhook_callback_verification') {
            return response($request->input('challenge'), 200);
        }

        // 2️⃣ Notificação de evento
        if ($messageType === 'notification') {
            $event            = $request->input('event');
            $subscriptionType = $request->input('subscription.type');
            $userId           = $event['broadcaster_user_id'] ?? null;

            if (! $userId) {
                return response('Missing user ID', 400);
            }

            // Pega token de app
            $clientId     = env('TWITCH_CLIENT_ID');
            $clientSecret = env('TWITCH_CLIENT_SECRET');
            $tokenResp = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'grant_type'    => 'client_credentials',
            ]);
            if (! $tokenResp->successful()) {
                return response('Token error', 500);
            }
            $accessToken = $tokenResp->json()['access_token'];

            // Busca dados do usuário na Twitch
            $userResp = Http::withHeaders([
                'Client-ID'     => $clientId,
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get('https://api.twitch.tv/helix/users', ['id' => $userId]);
            $user = $userResp->json()['data'][0] ?? null;
            if (! $user) {
                return response('User not found', 404);
            }

            $discordWebhookUrl = "https://discord.com/api/webhooks/1373658390835888181/ez5QZDr3lVjiHHc9TH9y6plwQQHf9GKhyOXR4veyxtSl8oehzla6iQRvZVzdQlbXTj8U";  // seu webhook

            // 1) stream.online: só ativa se título válido
            if ($subscriptionType === 'stream.online') {
                $streamResp = Http::withHeaders([
                    'Client-ID'     => $clientId,
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get('https://api.twitch.tv/helix/streams', ['user_id' => $userId]);
                if (! $streamResp->successful()) {
                    return response('Stream error', 500);
                }

                $stream = $streamResp->json()['data'][0] ?? null;
                $title  = $stream['title'] ?? '';
                $viewers = $stream['viewer_count'] ?? 0;

                // valida título
                $pattern = '/\bplay(?:ing)?\s?ravenor(?:\.online)?\b/i';
                if (! preg_match($pattern, $title)) {
                    Log::info("🔕 Título ignorado no start: \"{$title}\"");
                    return response('Unauthorized title', 204);
                }

                // marca início válido
                $now = Carbon::now('America/Sao_Paulo');
                Cache::put("stream_start_{$userId}", $now, 1440);
                Cache::put("valid_streaming_{$userId}", true, 1440);
                Cache::put("stream_title_{$userId}", $title, 1440);

                $message = [
                    'embeds' => [[
                        'title'       => "🔴 {$user['display_name']} está AO VIVO!",
                        'description' => "**Assista agora!**\n\n👤 `{$user['display_name']}` | 👁️ {$viewers} viewers\n📢 **Título:** {$title}",
                        'color'       => hexdec('9146FF'),
                        'thumbnail'   => ['url' => $user['profile_image_url']],
                        'url'         => 'https://twitch.tv/' . $user['login'],
                    ]]
                ];
            }

            // 2) stream.offline: encerra somente se estava válido
            elseif ($subscriptionType === 'stream.offline') {
                if (! Cache::get("valid_streaming_{$userId}")) {
                    Log::info("🚫 Ignorando offline sem live válida");
                    return response('Offline ignored', 204);
                }

                // contabiliza período final
                $this->flushPeriodHours($userId);

                // apaga cache
                Cache::forget("stream_start_{$userId}");
                Cache::forget("valid_streaming_{$userId}");
                Cache::forget("stream_title_{$userId}");

                $message = [
                    'embeds' => [[
                        'title'       => "🔌 {$user['display_name']} ficou offline",
                        'description' => "Transmissão encerrada.",
                        'color'       => hexdec('808080'),
                        'thumbnail'   => ['url' => $user['profile_image_url']],
                        'url'         => 'https://twitch.tv/' . $user['login'],
                    ]]
                ];
            }

            // 3) channel.update: três cenários
            elseif ($subscriptionType === 'channel.update') {
                $oldValid = Cache::get("valid_streaming_{$userId}", false);
                $oldTitle = Cache::get("stream_title_{$userId}", '');
                $newTitle = $event['title'] ?? '';
                $viewers = $stream['viewer_count'] ?? 0;

                // a) INVALID → VALID
                $pattern = '/\bplay(?:ing)?\s?ravenor(?:\.online)?\b/i';
                if (! $oldValid && preg_match($pattern, $newTitle)) {
                    // abre contagem a partir de agora
                    $now = Carbon::now('America/Sao_Paulo');
                    Cache::put("stream_start_{$userId}", $now, 1440);
                    Cache::put("valid_streaming_{$userId}", true,    1440);
                    Cache::put("stream_title_{$userId}", $newTitle, 1440);

                    $message = [
                        'embeds' => [[
                            'title'       => "🔴 {$user['display_name']} está AO VIVO!",
                            'description' => "**Assista agora!**\n\n👤 `{$user['display_name']}` | 👁️ {$viewers} viewers\n📢 **Título:** {$newTitle}",
                            'color'       => hexdec('9146FF'),
                            'thumbnail'   => ['url' => $user['profile_image_url']],
                            'url'         => 'https://twitch.tv/' . $user['login'],
                        ]]
                    ];
                }
                // b) VALID → INVALID
                elseif ($oldValid && ! preg_match($pattern, $newTitle)) {
                    // contabiliza e fecha
                    $this->flushPeriodHours($userId);
                    Cache::forget("stream_start_{$userId}");
                    Cache::forget("valid_streaming_{$userId}");
                    Cache::forget("stream_title_{$userId}");

                    $message = [
                        'embeds' => [[
                            'title'       => "🔌 {$user['display_name']} ficou offline",
                            'description' => "Transmissão encerrada.",
                            'color'       => hexdec('808080'),
                            'thumbnail'   => ['url' => $user['profile_image_url']],
                            'url'         => 'https://twitch.tv/' . $user['login'],
                        ]]
                    ];
                }
                // c) VALID → VALID diferente
                elseif ($oldValid && preg_match($pattern, $newTitle) && $newTitle !== $oldTitle) {
                    // contabiliza período anterior
                    $this->flushPeriodHours($userId);
                    // reinicia com novo título
                    $now = Carbon::now('America/Sao_Paulo');
                    Cache::put("stream_start_{$userId}", $now, 1440);
                    Cache::put("stream_title_{$userId}", $newTitle, 1440);

                    $message = [
                        'embeds' => [[
                            'title'       => "🔴 {$user['display_name']} está AO VIVO!",
                            'description' => "**Assista agora!**\n\n👤 `{$user['display_name']}` | 👁️ {$viewers} viewers\n📢 **Título:** {$newTitle}",
                            'color'       => hexdec('9146FF'),
                            'thumbnail'   => ['url' => $user['profile_image_url']],
                            'url'         => 'https://twitch.tv/' . $user['login'],
                        ]]
                    ];
                }
                // d) demais (invalid→invalid ou sem mudança relevante)
                else {
                    Log::info("🚫 Ignorando channel.update sem efeito útil");
                    return response('Title change ignored', 204);
                }
            }
            else {
                // outros eventos
                return response('Ignored', 204);
            }

            // envia mensagem ao Discord
            Http::post($discordWebhookUrl, $message);
            return response('OK', 200);
        }

        // default
        return response('OK', 200);
    }

    /**
     * Calcula e persiste horas entre o last-start e agora.
     */
    protected function flushPeriodHours($userId)
    {
        $startTime = Cache::get("stream_start_{$userId}");
        if (! $startTime) {
            return;
        }

        $endTime      = Carbon::now('America/Sao_Paulo');
        $start        = Carbon::parse($startTime);
        $minutes      = $start->diffInMinutes($endTime);
        $hoursDecimal = round($minutes / 60, 2);
        $date         = $start->toDateString();

        $existing = DB::table('streamer_hours')
            ->where('streamer_id', $userId)
            ->where('date',        $date)
            ->first();

        if ($existing) {
            DB::table('streamer_hours')
                ->where('id', $existing->id)
                ->update([
                    'hours'      => $existing->hours + $hoursDecimal,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('streamer_hours')->insert([
                'streamer_id' => $userId,
                'date'        => $date,
                'hours'       => $hoursDecimal,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        Log::info("🕒 Período contabilizado: {$hoursDecimal}h em {$date}");
    }
}
