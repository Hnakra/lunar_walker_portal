<?php

namespace App\Http\Controllers\Games\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Place;
use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class GameController , получает данные и выводит их на странице Игра
 * @package App\Http\Controllers\Games\Game
 */
class GameController extends Controller
{
    public function index($id_game){
        $game = Game::find($id_game);
        $tournament = Tournament::find($game->id_tournament);
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
        $list1Users = [];

        foreach ($users_team1 as $user){
            array_push($list1Users, User::find( $user->id_user));
            array_push($list1Robots, Robot::where('id_master', $user->id_user)->get());
        }

        $list2Robots = [];
        $list2Users = [];

        foreach ($users_team2 as $user){
            array_push($list2Users, User::find( $user->id_user));
            array_push($list2Robots, Robot::where('id_master', $user->id_user)->get());
        }

        return view('pages.game',[
            'game' => $game,
            'team_1' => $information_team1,
            'team_2' => $information_team2,
            'users_team1' =>  $list1Users,
            'users_team2' =>  $list2Users,
            'list1Robots' => $list1Robots,
            'list2Robots' => $list2Robots,
            'tournament' => $tournament,
            'organizer' => $organizer,
            'place' => $place
        ]);
    }
}
