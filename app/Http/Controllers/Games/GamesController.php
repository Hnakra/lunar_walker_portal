<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index(){
        $items = Game::all();

        return view('pages.games',[
            'games' => $items
        ]);
    }
}
