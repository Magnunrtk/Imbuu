<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmployeeTimeClock;
use App\Models\EmployeePayment;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\WebAccounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TimeClockController extends Controller
{

    public function showCodeForm()
    {
        $accountId = Auth::user()->id;

        if($accountId == 199361){

            return redirect()->route('admin.timeClock.luanPage');
        }

        return view('admin.timeClock.employee_code_form');
    }

    public function showTimeForm(Request $request)
    {
        $employeeCode = $request->input('employeeCode');
        
        $validCodes = [
            '746519832' => 'Kauê',
            '382957104' => 'Gabriel',
            '591026483' => 'Luan',
            '746519854' => 'KaueDesktop'
        ];

        if (isset($validCodes[$employeeCode])) {
            $employeeName = $validCodes[$employeeCode];

            if ($employeeName == 'Luan') {
                return redirect()->route('admin.timeClock.luanPage');
            } else {

                return redirect()->route('admin.timeClock.index', ['employeeName' => $employeeName]);
            }
        } else {
            return back()->with('error', 'Invalid employee code');
        }
    }

    public function luanPage(Request $request)
    {
        $employeesOnline = EmployeeTimeClock::where('status', 'online')
                                            ->get(['employee_name', 'task', 'elapsed_time', 'created_at']);
    
        $hiredEmployees = Employee::all();
    
        $unpaidRecords = EmployeeTimeClock::select('employee_name', 'task', 'elapsed_time', 'tasks_day')
        ->orderBy('id', 'desc')
        ->get();
    
        $payrollRecords = EmployeeTimeClock::where('payment', 'unpaid')
            ->select('employee_name')
            ->selectRaw("SEC_TO_TIME(SUM(TIME_TO_SEC(elapsed_time))) as total_hours")
            ->selectRaw("GROUP_CONCAT(id) as unpaid_ids")
            ->groupBy('employee_name')
            ->get();

        $uniqueEmployeeNames = $unpaidRecords->pluck('employee_name')->unique();
    
        $paidReceipts = EmployeePayment::select('employee_name', 'proof as receipt_file', 'payment_date', 'pay_due')
            ->get()
            ->map(function ($receipt) {
                $receipt->file_url = route('download.receipt', ['filename' => basename($receipt->receipt_file)]);
                return $receipt;
            });

        return view('admin.timeClock.luanPage', compact('employeesOnline', 'payrollRecords', 'hiredEmployees', 'unpaidRecords', 'paidReceipts', 'uniqueEmployeeNames'));
    }
    
    
    
    public function index($employeeName)
    {
        $today = Carbon::today('America/Sao_Paulo')->toDateString();
        
        $registrosHoje = EmployeeTimeClock::where('employee_name', $employeeName)
                                          ->where('date_only', $today)
                                          ->get();

        $totalSeconds = 0;
        foreach ($registrosHoje as $registro) {
            $timeParts = explode(':', $registro->elapsed_time);

            if (count($timeParts) === 3) {
                $hours = (int) $timeParts[0];
                $minutes = (int) $timeParts[1];
                $secondsPart = (int) $timeParts[2];

                $seconds = ($hours * 3600) + ($minutes * 60) + $secondsPart;
            } else {
                Log::error("⛔ Formato inválido em elapsed_time: {$registro->elapsed_time}");
                $seconds = 0; // ou trate conforme sua regra de negócio
            }

            $totalSeconds += $seconds;
        }
    
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;
        $formattedTime = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        
        $registrosUnpaid = EmployeeTimeClock::where('employee_name', $employeeName)
                                            ->where('payment', 'unpaid')
                                            ->get();
    
        $totalUnpaidSeconds = 0;
        foreach ($registrosUnpaid as $registro) {
            $timeParts = explode(':', $registro->elapsed_time);
            
                        if (count($timeParts) === 3) {
                $hours = (int) $timeParts[0];
                $minutes = (int) $timeParts[1];
                $secondsPart = (int) $timeParts[2];

                $seconds = ($hours * 3600) + ($minutes * 60) + $secondsPart;
            } else {
                Log::error("⛔ Formato inválido em elapsed_time: {$registro->elapsed_time}");
                $seconds = 0; // ou trate conforme sua regra de negócio
            }

            $totalUnpaidSeconds += $seconds;
        }
    
        $totalUnpaidHours = floor($totalUnpaidSeconds / 3600);
        $totalUnpaidMinutes = floor(($totalUnpaidSeconds % 3600) / 60);
        $totalUnpaidSeconds = $totalUnpaidSeconds % 60;
        $totalUnpaidTime = sprintf("%02d:%02d:%02d", $totalUnpaidHours, $totalUnpaidMinutes, $totalUnpaidSeconds);
    
        $paidReceipts = EmployeePayment::where('employee_name', $employeeName)
                                    ->select('employee_name', 'proof as receipt_file', 'payment_date', 'pay_due')
                                    ->get()
                                    ->map(function ($receipt) {
                                        $receipt->file_url = route('download.receipt', ['filename' => basename($receipt->receipt_file)]);
                                        return $receipt;
                                    });
    
        $isLuan = $employeeName == 'Luan';

        return view('admin.timeClock.index', compact('formattedTime', 'employeeName', 'registrosUnpaid', 'totalUnpaidTime', 'isLuan', 'paidReceipts'));
    }
    
    
    public function store(Request $request)
    {

        $data = $request->validate([
            'employeeName' => 'required|string|in:Kauê,Gabriel',
            'task' => 'required|string|max:255',
            'tasks_day' => 'nullable|string',
            'elapsedTime' => 'required|string',
        ]);

        $elapsedTimeFormatted = date('H:i:s', strtotime($data['elapsedTime']));
    
        $today = Carbon::today('America/Sao_Paulo')->toDateString();

        $existingTimeClock = EmployeeTimeClock::where('employee_name', $data['employeeName'])
            ->where('date_only', $today) 
            ->first();
    
        if ($existingTimeClock) {
            $existingTimeClock->elapsed_time = $elapsedTimeFormatted;
            $existingTimeClock->task = $data['task']; 
            $existingTimeClock->tasks_day = $data['tasks_day']; 
            $existingTimeClock->save(); 
        } else {
            EmployeeTimeClock::create([
                'employee_name' => $data['employeeName'],
                'task' => $data['task'],
                'tasks_day' => $data['tasks_day'],
                'elapsed_time' => $elapsedTimeFormatted, 
                'status' => 'online', 
                'date_only' => $today, 
            ]);
        }
    
        return redirect()->route('admin.timeClock.index', ['employeeName' => $data['employeeName']])->with('success', 'Time registered successfully!');
    }

    private function addTime($time1, $time2)
    {
        $time1 = strtotime($time1);
        $time2 = strtotime($time2);

        $sum = $time1 + $time2;

        return date('H:i:s', $sum);
    }

    public function updateStatus(Request $request)
    {
 
        $data = $request->validate([
            'employeeName' => 'required|string|in:Kauê,Gabriel,Luan', 
            'status' => 'required|in:online,offline', 
            'task' => 'required|string', 
        ]);
    
        $today = Carbon::today('America/Sao_Paulo')->toDateString();
    
        $registro = EmployeeTimeClock::where('employee_name', $data['employeeName'])
                                     ->where('date_only', $today)
                                     ->first();

        if ($registro) {
            $registro->update([
                'status' => $data['status'],
                'task' => $data['task'], 
            ]);
        } else {

            EmployeeTimeClock::create([
                'employee_name' => $data['employeeName'],
                'status' => $data['status'],
                'task' => $data['task'],
                'date_only' => $today,
            ]);
        }

        $this->sendDiscordNotification($data['employeeName'], $data['task'], $data['status']);
    
        return response()->json(['message' => 'Status and task updated successfully']);
    }
    
    public function sendDiscordNotification($employeeName, $task, $status)
    {
        $dataHora = Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i:s'); 
    
        $content = "
        ```🚨 [Ravenor] Atualização de Status 👨‍💻
    
Sistema de Gestão
Data/Hora: $dataHora
Funcionário: $employeeName
Tarefa: $task
Status: $status```";
    
        $webhook = 'https://discordapp.com/api/webhooks/1337350663776112691/Ij5nghr84vdjQ3_ob0wMpPK2rR46eib6FQYlu6_QjcGqpG9ZI6W2BkJmFYjobA_aND_o';
    
        $dataToSend = [
            'content' => $content
        ];
    
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => json_encode($dataToSend)
            ]
        ];
    
        // $context = stream_context_create($options);
        // file_get_contents($webhook, false, $context);
    }
    
    
}
