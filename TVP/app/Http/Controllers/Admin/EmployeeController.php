<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\EmployeePayment;
use App\Models\EmployeeTimeClock;
use Carbon\Carbon;

class EmployeeController extends Controller
{

    public function create()
    {
        return view('admin.employee.create'); 
    }

    public function store(Request $request)
    {

        $request->validate([
            'employee_name' => 'required|string|max:255',
            'pix_key' => 'required|string|max:255|unique:employees',
            'position' => 'required|string|max:255',
        ]);

        $employee = new Employee();
        $employee->employee_name = $request->employee_name;
        $employee->pix_key = $request->pix_key;
        $employee->position = $request->position;
        $employee->save(); 

        return back()->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function storePayment(Request $request)
    {

        $request->validate([
            'employee_name' => 'required|string|max:255',
            'pay_due' => 'required|numeric',
            'proof' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'unpaid_ids' => 'required|string'
        ]);
    
        $unpaidIds = explode(',', $request->unpaid_ids);

        $proofPath = $request->file('proof')->store('employee_payments_proof', 'public');
    
        $payment = new EmployeePayment();
        $payment->employee_name = $request->employee_name;
        $payment->pay_due = $request->pay_due;
        $payment->payment_date = Carbon::now()->toDateString();
        $payment->proof = $proofPath;
        $payment->save();
    
        EmployeeTimeClock::whereIn('id', $unpaidIds)->update(['payment' => 'paid']);
    
        return redirect()->back()->with('success', 'Pagamento registrado com sucesso!');
    }
    
}
