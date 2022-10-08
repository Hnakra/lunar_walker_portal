<?php

namespace App\Http\Controllers\Games\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index($id){
        $item = Game::where('id', $id)->get();

        return view('pages.game',[
            'game' => $item
        ]);
    }
}
