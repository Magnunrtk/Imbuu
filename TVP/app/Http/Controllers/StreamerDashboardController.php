<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Streamer;
use App\Models\StreamerReference;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class StreamerDashboardController extends Controller
{
    public function index()
    {
        if (!Session::has('streamer_name')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }
    
        $streamerName = Session::get('streamer_name');
        $streamer = Streamer::where('name', $streamerName)->first();
    
        $couponCode = $streamer ? ($streamer->coupon_approved ? $streamer->coupon_code : $streamer->temp_coupon_code) : null;
        $couponApproved = $streamer ? $streamer->coupon_approved : false;
        $isPending = $streamer && !$streamer->coupon_approved && $streamer->temp_coupon_code;
    
        $streamerId = Session::get('streamer_id');
    
        $streamer_references = StreamerReference::where('streamer_id', $streamerId)
            ->where('status', '!=', 'pending')
            ->get();
    
        $semanas = [];
        foreach ($streamer_references as $reference) {
            $semana = Carbon::parse($reference->created_at)->startOfWeek()->format('d/m/Y');
    
            if (!isset($semanas[$semana])) {
                $semanas[$semana] = [
                    'processadas' => 0,
                    'em_analise' => 0,
                    'ganhos_totais' => 0.00
                ];
            }
    
            if ($reference->value > 0) {
                $semanas[$semana]['processadas'] += 1;
                $semanas[$semana]['ganhos_totais'] += $reference->value;
            } else {
                $semanas[$semana]['em_analise'] += 1;
            }
        }
    
        return view('account.manage.streamer.dashboard', compact('streamerName', 'streamer', 'couponCode', 'couponApproved', 'isPending', 'semanas'));
    }
    

    public function createCoupon(Request $request)
    {
        if (!Session::has('streamer_id')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }

        $request->validate([
            'coupon_code' => 'required|string|max:20|unique:streamers,coupon_code',
        ]);

        $streamer = Streamer::find(Session::get('streamer_id'));
        if (!$streamer) {
            return redirect()->route('account.manage.streamer.dashboard')->withErrors(['error' => 'Streamer not found.']);
        }

        $streamer->temp_coupon_code = $request->coupon_code;
        $streamer->coupon_approved = 0;
        $streamer->save();

        $webhook = 'https://discord.com/api/webhooks/1345109058113241149/vUJMasL7NXqhUB_3dZEtDaQb2EhaJeBZeqreDyTSk8oHUzOvUTLlmuKZpLExTG0uF5sM';
        $dataHora = date('d/m/Y H:i:s');

        $data = [
            'content' => ("    
        ```[Ravenor] Novo cupom aguardando aprovação!
        
Streamer: $streamer->name
Cupom: $request->coupon_code
        
Data/Hora: $dataHora```")
        ];
        
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);

        return redirect()->route('account.manage.streamer.dashboard')->with('success', 'Coupon submitted for approval.');
    }

    public function updateCoupon(Request $request)
    {
        if (!Session::has('streamer_id')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }

        $request->validate([
            'new_coupon_code' => 'required|string|max:20|unique:streamers,coupon_code',
        ]);

        $streamer = Streamer::find(Session::get('streamer_id'));
        if (!$streamer) {
            return redirect()->route('account.manage.streamer.dashboard')->withErrors(['error' => 'Streamer not found.']);
        }

        $oldCoupon = $streamer->coupon_code;
        $streamer->temp_coupon_code = $request->new_coupon_code;
        $streamer->coupon_approved = 0;
        $streamer->save();

        $webhook = 'https://discord.com/api/webhooks/1345109058113241149/vUJMasL7NXqhUB_3dZEtDaQb2EhaJeBZeqreDyTSk8oHUzOvUTLlmuKZpLExTG0uF5sM';
        $dataHora = date('d/m/Y H:i:s');

        $data = [
            'content' => ("    
            ```[Ravenor] Pedido de alteração de cupom!

Streamer: $streamer->name
Cupom Antigo: $oldCoupon
Novo Cupom: $request->new_coupon_code

Data/Hora: $dataHora```")
        ];
        
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);

        return redirect()->route('account.manage.streamer.dashboard')->with('success', 'Coupon change request submitted for approval.');
    }

    public function updatePixKey(Request $request)
    {
        if (!Session::has('streamer_id')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }
    
        $request->validate([
            'pix_key' => 'required|string|max:100|unique:streamers,chave_pix',
        ]);
    
        $streamer = Streamer::find(Session::get('streamer_id'));
        if (!$streamer) {
            return redirect()->route('account.manage.streamer.dashboard')->withErrors(['error' => 'Streamer not found.']);
        }
    
        $oldPixKey = $streamer->chave_pix;
        $streamer->temp_pix_key = $request->pix_key;
        $streamer->chave_pix_approved = 0; 
        $streamer->save();
    
        $webhook = 'https://discord.com/api/webhooks/1345109058113241149/vUJMasL7NXqhUB_3dZEtDaQb2EhaJeBZeqreDyTSk8oHUzOvUTLlmuKZpLExTG0uF5sM';
        $dataHora = date('d/m/Y H:i:s');
    
        $data = [
            'content' => ("    
            ```[Ravenor] Pedido de alteração de chave Pix!
    
Streamer: $streamer->name
Chave Pix Antiga: $oldPixKey
Nova Chave Pix: $request->pix_key
    
Data/Hora: $dataHora```")
        ];
        
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);
    
        return redirect()->route('account.manage.streamer.dashboard')->with('success', 'Pix key change request submitted for approval.');
    }

    public function associateAccount(Request $request)
    {
        if (!Session::has('streamer_id')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }

        $streamer = Streamer::find(Session::get('streamer_id'));
        if (!$streamer) {
            return redirect()->route('account.manage.streamer.dashboard')->withErrors(['error' => 'Streamer not found.']);
        }

        $userId = Auth::id();

        $streamer->account_associate = $userId;
        $streamer->save();

        return redirect()->route('account.manage.streamer.dashboard')
            ->with('success', 'Account successfully associated.');
    }

    public function dissociateAccount()
    {
        $userId = Auth::id();

        $streamer = Streamer::where('account_associate', $userId)->first();

        if (!$streamer) {
            return redirect()->route('account.manage.streamer.dashboard')->withErrors(['error' => 'No associated streamer account found.']);
        }

        $streamer->account_associate = null;
        $streamer->save();

        return redirect()->route('account.manage.streamer.dashboard')->with('success', 'Your account has been dissociated.');
    }
        
    public function getReferencesByMonth(Request $request)
    {
        if (!Session::has('streamer_name')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $streamerId = Session::get('streamer_id');
        $month = $request->query('month', Carbon::now()->format('m'));
        $year = Carbon::now()->format('Y');
    
        $startOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $interval = floor($endOfMonth->day / 4); 
        $semanas = [];
    
        for ($i = 0; $i < 4; $i++) {
            $weekStart = $startOfMonth->copy()->addDays($i * $interval);
            $weekEnd = $weekStart->copy()->addDays($interval - 1);
  
            if ($i == 3) {
                $weekEnd = $endOfMonth;
            }
    
            $semanas[$weekStart->format('d/m/Y')] = [
                'week_end' => $weekEnd->format('d/m/Y'),
                'processadas' => 0,
                'em_analise' => 0,
                'ganhos_totais' => 0.00
            ];
        }
   
        $streamerReferences = StreamerReference::where('streamer_id', $streamerId)
            ->whereBetween('created_at', [$startOfMonth->startOfDay(), $endOfMonth->endOfDay()]) 
            ->get();
    
        foreach ($streamerReferences as $reference) {
            $createdDate = Carbon::parse($reference->created_at)->startOfDay(); 
    
            foreach ($semanas as $weekStart => &$semana) {
                $weekStartCarbon = Carbon::createFromFormat('d/m/Y', $weekStart)->startOfDay();
                $weekEndCarbon = Carbon::createFromFormat('d/m/Y', $semana['week_end'])->endOfDay();
    
                if ($createdDate->between($weekStartCarbon, $weekEndCarbon)) {
                    if ($reference->value > 0) {
                        $semana['processadas'] += 1;
                        $semana['ganhos_totais'] += $reference->value;
                    } else {
                        $semana['em_analise'] += 1;
                    }
                    break;
                }
            }
        }
    
        return response()->json($semanas);
    }
    
    public function getMonthlyEarnings()
    {
        if (!Session::has('streamer_name')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $streamerId = Session::get('streamer_id');
        $year = Carbon::now()->year;

        $earnings = DB::table('streamer_references')
            ->where('streamer_id', $streamerId)
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->select(DB::raw('MONTH(created_at) as month, SUM(value) as total_earnings'))
            ->get();
    
        $monthlyEarnings = array_fill(1, 12, 0);
        $totalEarnings = 0;

        foreach ($earnings as $earning) {
            $monthlyEarnings[$earning->month] = $earning->total_earnings;
            $totalEarnings += $earning->total_earnings;
        }
    
        return response()->json([
            'monthlyEarnings' => $monthlyEarnings,
            'totalEarnings' => $totalEarnings
        ]);
    }
    


}
