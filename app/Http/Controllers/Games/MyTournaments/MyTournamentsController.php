<?php

namespace App\Http\Controllers\Games\MyTournaments;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class MyTournamentsController extends Controller
{
    public function index(){
        $items = Tournament::all();

        return view('pages.tournaments',[
            'tournaments' => $items
        ]);
    }
}
