<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Place;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

/**
 * Class GamesController, , получает данные и выводит их на странице Игры
 * @package App\Http\Controllers\Games
 */
class GamesController extends Controller
{
    public function index(){
        $items = Tournament::all()->sortByDesc('created_at');
        for($i = 0; $i < count($items); $i++){
            $items[$i]['place_name'] = Place::where('id', $items[$i]->id_place)->get()->first()->name;
            $items[$i]['games'] = $this->getGames($items[$i]->id);
        }
        return view('pages.games',[
            'tournaments' => $items
        ]);
    }

    /**
     * Метод, возвращающий игры турнира
     * @param $id_tournament
     * @return Game[]|\LaravelIdea\Helper\App\Models\_IH_Game_C
     */
    private function getGames($id_tournament)
    {
        $games = Game::where('id_tournament', $id_tournament)->get();
        for($i = 0; $i < count($games); $i++){
            $games[$i]['name_team_1'] = Team::find($games[$i]->id_team_1)->name;
            $games[$i]['name_team_2'] = Team::find($games[$i]->id_team_2)->name;
        }
        return $games;
    }
}
