@extends('layouts.main')
@section('title', 'Мои турниры')
@section('style', 'tournaments.css')
@section('content')
    @include('content.games.tournaments.tournaments')
@endsection
