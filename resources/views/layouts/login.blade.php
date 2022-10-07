@extends('layouts.main')
@section('title', 'Вход')
@section('style', 'login.css')
@section('content')
    <h2>@yield('title')</h2>
    {{ $slot }}
@endsection
