@extends('template.layout_admin')

@section('content')
<div class="container">
    <h1>Characters Por Account</h1>


    <style>
        input[type="text"], input[type="number"], select {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            height: 20px;
            width: 150px;
        }
    
        button[type="submit"] {
            width: 100px;
            background-color: #6f42c1;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            height: 20px;
        }
    
    </style>
        
    <div class="container" style="display: flex; content-align: center">
        <form method="GET" action="{{ route('admin.duplicate-accounts.search') }}" class="row align-items-center">
            <label for="search" style="margin-left: -8px">Buscar Account ID:</label>
            <input type="text" name="search" value="{{ request('search') }}">
            <button type="submit" style="margin-left: 5px">Buscar</button>
        </form>
    </div>

    <br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Número de Characters</th>
            </tr>
        </thead>
        <tbody>
            @foreach($duplicateAccounts as $account)
                <tr>
                    <td>{{ $account->account_id }}</td>
                    <td>{{ $account->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
