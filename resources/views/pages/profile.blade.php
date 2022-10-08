@extends('layouts.main')
@section('title', 'Профиль')
@section('style', 'profile.css')
@section('content')
    <h2>@yield('title')</h2>
    {{ $slot }}
@endsection
