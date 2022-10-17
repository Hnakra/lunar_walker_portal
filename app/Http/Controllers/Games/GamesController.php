<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Place;
use App\Models\Tournament;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index(){
        $items = Tournament::all();
        for($i = 0; $i < count($items); $i++){
            $items[$i]['place_name'] = Place::where('id', $items[$i]->id_place)->get()->first()->name;
        }

        return view('pages.games',[
            'tournaments' => $items
        ]);
    }
}
