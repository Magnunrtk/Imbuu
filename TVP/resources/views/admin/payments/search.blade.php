@extends('template.layout')
@section('submenuItem', 'characters')
@section('content')
    @if(isset($orderHistory))
        @include('admin.payments.details')
    @endif
    @include('admin.payments.form')
@endsection
