<?php

namespace App\Http\Controllers\Games\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class StatisticsController, получает данные и выводит их на странице Статистика
 * @package App\Http\Controllers\Games\Statistics
 */
class StatisticsController extends Controller
{
    public function index(){
        $games = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))->
            leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')->
            leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')->
            leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')->
            get()->sortByDesc('updated_at');
        foreach ($games as $game){
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }

        return view('pages.statistics', ["games" => $games]);
    }
}
