<?php

namespace App\Http\Controllers\Games\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index($id_game){
        $item = Game::find($id_game);

        return view('pages.game',[
            'game' => $item
        ]);
    }
}
