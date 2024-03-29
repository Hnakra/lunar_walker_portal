<?php

namespace App\Http\Controllers\Games\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CounterController, получает данные и выводит их на странице Счетчика
 * @package App\Http\Controllers\Games\Game
 */
class CounterController extends Controller
{
    public function index($id_game){
        $game = Game::find($id_game);
        if(!Auth::check() || Auth::user()->isUser()){
            return redirect("/game/".$id_game);

        }

        return view('pages.counter',[
            'game' => $game,

        ]);
    }
}
