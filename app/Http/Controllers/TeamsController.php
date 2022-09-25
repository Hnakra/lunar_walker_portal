<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamsController extends Controller
{

    public function index($id_place){
        $teams = Team::where('id_place', $id_place)->get();
        $teamsWithPlayers = [];
        foreach ($teams as $team){
            /*$teamsWithPlayers += ["team" => $team];*/
            $players = Player::where('id_team', $team->id)->get();
            $listUsers = [];
            $listRobots = [];
            foreach ($players as $player){
                array_push($listUsers, User::where('id', $player->id_user)->get());
                array_push($listRobots, Robot::where('id', $player->id_robot)->get());
            }
            array_push($teamsWithPlayers, ["team" => $team, "listUsers"=>$listUsers, "listRobots"=>$listRobots]);
        }

        return view('pages.teams',[
            'teamsWithPlayers' => $teamsWithPlayers,
            'id_place' => $id_place
        ]);
    }
}
