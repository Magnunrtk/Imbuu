@extends('template.layout')
@section('title', 'Characters')
@section('submenuItem', 'characters')
@section('content')
    @include('community.view.character.form')
@endsection
