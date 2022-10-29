<?php

namespace App\Http\Controllers\Games\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index($id_game){
        $game = Game::find($id_game);
/*        $tournament = Tournament::find($game->id_tournament);
        $organizer = User::find($tournament->id_creator);
        $place = Place::find($tournament->id_place);
        $information_team1 = Team::find($game->id_team_1);
        $information_team2 = Team::find($game->id_team_2);
        $users_team1 = Player::where('id_team', $game->id_team_1)->
        leftJoin('users','players.id_user', '=','users.id')->get();
        $users_team2 = Player::where('id_team', $game->id_team_2)->
        leftJoin('users','players.id_user', '=','users.id')->get();
        $users_robots1 = Player::where('id_team', $game->id_team_1)->get();

        $list1Robots = [];
        foreach ($users_team1 as $user){
            array_push($list1Robots, Robot::where('id_master', $user->id_user)->get());
        }

        $list2Robots = [];
        foreach ($users_team2 as $user){
            array_push($list2Robots, Robot::where('id_master', $user->id_user)->get());
        }*/

        return view('pages.counter',[
            'game' => $game,

        ]);
    }
}
