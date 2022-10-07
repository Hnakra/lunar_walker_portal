<?php

namespace App\Http\Controllers\Games\MyTournaments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyTournamentsController extends Controller
{
    public function index(){
        return view('pages.tournaments');
    }
}
