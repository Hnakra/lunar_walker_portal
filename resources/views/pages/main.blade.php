@extends('layouts.main')
@section('title', 'Главная')
@section('style', 'main.css')
@section('additional_style_1', 'games.css')
@section('additional_style_2', 'statistics.css')
@section('content')
    @include('content.main.main')
@endsection
