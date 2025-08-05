@extends('template.layout')
@section('submenuItem', 'characters')
@section('content')
    @if(isset($playerInfo))
        @include('community.view.character.details')
    @endif
    @include('community.view.character.form')
@endsection
