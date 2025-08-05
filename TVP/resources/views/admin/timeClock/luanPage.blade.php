@extends('template.layout_admin')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/admin/timeClock/luanPage.css') }}?v={{ time() }}">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="container main-container">

    <h1>Welcome, <small style="color:rgb(43, 43, 106)">Guilherme Sebastiani</small></h1>

    <br>
    <div class="tabs">
        <button class="tab-button active" onclick="showTab('workingNow')">Working Now</button>
        <button class="tab-button" onclick="showTab('payroll')">Payroll</button>
        <button class="tab-button" onclick="showTab('registerEmployee')">Register New Employee</button>
        <button class="tab-button" onclick="showTab('hiredEmployees')">Hired Employees</button> 
        <button class="tab-button" onclick="showTab('paidReceipts')">Paid Receipts</button> 
        <button class="tab-button" onclick="showTab('unpaidRecords')">Developed Systems</button>
    </div>

    <div id="workingNow" class="tab-content active">
        <h1 class="section-title">Working Now</h1>

        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Task</th>
                    <th>Recorded Time</th>
                    <th>Started At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employeesOnline as $registro)
                    <tr>
                        <td class="employee-name">
                            <span class="status-dot online"></span>
                            {{ $registro->employee_name }}
                        </td>
                        <td class="employee-task">{{ $registro->task }}</td>
                        <td class="elapsed-time">{{ $registro->elapsed_time }}</td>
                        <td class="created-at">{{ $registro->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="payroll" class="tab-content">
        <h1 class="section-title">Payroll</h1>
        
        <div class="hourly-rate-container">
            <label for="hourlyRate" class="hourly-rate-label">Hourly Rate:</label>
            <input type="number" id="hourlyRate" class="hourly-rate-input" placeholder="Enter hourly rate" value="0" />
        </div>

        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Total Unpaid Hours</th>
                    <th>Due Payment</th>
                    <th>Chave PIX</th>
                    <th>Comprovante</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $payrollRecords = $payrollRecords->sortByDesc('total_hours');
                @endphp

                @foreach($payrollRecords as $registro)
                    <tr>
                        <td class="employee-name">
                            {{ $registro->employee_name }}
                        </td>
                        
                        <td class="total-hours">
                            {{ $registro->total_hours }}
                        </td>
                        
                        <td class="pay-due" id="payDueCell-{{ $registro->employee_name }}">
                            {{ $registro->pay_due }}
                        </td>
                        
                        <td>
                            @php
                                $employee = $hiredEmployees->firstWhere('employee_name', $registro->employee_name);
                            @endphp
                            {{ $employee ? $employee->pix_key : 'Chave PIX não encontrada' }}
                        </td>
            
                        <td>
                            <form action="{{ route('admin.employee.payment') }}" method="POST" enctype="multipart/form-data" id="form-{{ $registro->employee_name }}">
                                @csrf
                                <input type="hidden" name="employee_name" value="{{ $registro->employee_name }}">
                                <input type="hidden" name="pay_due" id="payDueInput-{{ $registro->employee_name }}" value="{{ $registro->pay_due }}">
                                <input type="hidden" name="pix_key" value="{{ $employee ? $employee->pix_key : 'Chave PIX não encontrada' }}">

                                <input type="hidden" name="unpaid_ids" value="{{ $registro->unpaid_ids }}">
                                
                                <input type="file" name="proof" accept="image/*, .pdf" required />
                            </form>
                        </td>
            
                        <td>                                  
                            <button type="button" class="btn btn-primary" onclick="submitForm('{{ $registro->employee_name }}')">Registrar Pagamento</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>

    <div id="registerEmployee" class="tab-content">
        <h1 class="section-title">Register New Employee</h1>

        <form action="{{ route('admin.employee.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employeeName">Employee Name:</label>
                <input type="text" id="employeeName" name="employee_name" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="pixKey">PIX Key:</label>
                <input type="text" id="pixKey" name="pix_key" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" class="form-control" required />
            </div>

            <br>

            <button type="submit" class="btn btn-primary">Register Employee</button>
        </form>
    </div>

    <div id="hiredEmployees" class="tab-content">
        <h1 class="section-title">Hired Employees</h1>

        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Position</th>
                    <th>PIX Key</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hiredEmployees as $employee)
                    <tr>
                        <td>{{ $employee->employee_name }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->pix_key }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="paidReceipts" class="tab-content">
        <h1 class="section-title">Paid Receipts</h1>

        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Payment Amount</th>
                    <th>Receipt</th>
                    <th>Date of Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paidReceipts as $receipt)
                    <tr>
                        <td>{{ $receipt->employee_name }}</td>
                        <td>R$ {{ number_format($receipt->pay_due, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ $receipt->file_url }}" target="_blank">
                                Download PDF
                            </a>
                        </td>
                        <td>{{ $receipt->payment_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="unpaidRecords" class="tab-content">
        <h1 class="section-title">All Records</h1>
    
        <label for="employee_name">Filter by Employee Name:</label>
        <select name="employee_name" id="employee_name">
            <option value="">Select Employee</option>
            @foreach($uniqueEmployeeNames as $employeeName)
                <option value="{{ $employeeName }}">
                    {{ $employeeName }}
                </option>
            @endforeach
        </select>

        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Task</th>
                    <th>Elapsed Time</th>
                    <th>Task Day</th>
                </tr>
            </thead>
            <tbody id="recordsBody">
                @foreach($unpaidRecords as $registro)
                    <tr class="record-row" data-employee-name="{{ $registro->employee_name }}">
                        <td>{{ $registro->employee_name }}</td>
                        <td>{{ $registro->task }}</td>
                        <td>{{ $registro->elapsed_time }}</td>
                        <td>{{ $registro->task_day }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="{{ asset('assets/js/admin/timeClock/luanPage.js') }}"></script>

@endsection
