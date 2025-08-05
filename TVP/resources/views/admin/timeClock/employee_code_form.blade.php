@extends('template.layout_admin')

@section('content')

    <link rel="stylesheet" href="{{ asset('assets/css/admin/timeClock/employee_code_form.blade.css') }}?v=a1">

    <div class="container">
        <h1>Enter Employee Code</h1>

        <form action="{{ route('admin.timeClock.showForm') }}" method="POST">
            @csrf
            <div>
                <label for="employeeCode">Employee Code:</label>
                <input type="text" id="employeeCode" name="employeeCode" required placeholder="Enter the employee code">
            </div>

            <button type="submit">Submit</button>
        </form>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

@endsection
