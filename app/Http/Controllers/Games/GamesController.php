<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index(){
        $items = Tournament::all();

        return view('pages.games',[
            'tournaments' => $items
        ]);
    }
}
