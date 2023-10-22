<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class TeamsController, получает данные и выводит их на странице Команды
 * @package App\Http\Controllers\Teams
 */
class TeamsController extends Controller
{

    public function index(/*$id_place*/)
    {
        $teams = Team::all();/*Team::where('id_place', $id_place)->get();*/
        $teamsWithPlayers = [];
        foreach ($teams as $team) {
            /*$teamsWithPlayers += ["team" => $team];*/
            $players = Player::where('id_team', $team->id)->get();
            $listUsers = [];
            $listRobots = [];
            foreach ($players as $player) {
                $user = User::where('id', $player->id_user)->get()->first();
                $user->photo = (isset($user->profile_photo_path) && is_readable("storage/$user->profile_photo_path")) ?
                    "../storage/$user->profile_photo_path" :
                    "https://ui-avatars.com/api/?name=" . $user->name . "&color=7F9CF5&background=EBF4FF";
                array_push($listUsers, $user);
                $robots = Robot::where('id_master', $player->id_user)->get();
                foreach ($robots as $robot) {
                    $robot->photo = is_readable("storage/robots/$robot->id/$robot->img") ? "../storage/robots/$robot->id/$robot->img" : "https://ui-avatars.com/api/?name=" . $robot->name . "&color=7F9CF5&background=EBF4FF";
                }
                array_push($listRobots, $robots);
            }
            $trainer = User::find($team->id_trainer);
            if ($trainer) {
                $robots = Robot::where('id_master', $trainer->id)->get();
                foreach ($robots as $robot) {
                    $robot->photo = is_readable("storage/robots/$robot->id/$robot->img") ? "../storage/robots/$robot->id/$robot->img" : "https://ui-avatars.com/api/?name=" . $robot->name . "&color=7F9CF5&background=EBF4FF";
                }
                array_push($listRobots, $robots);
            }
            array_push($teamsWithPlayers, ["trainer" => $trainer, "team" => $team, "listUsers" => $listUsers, "listRobots" => $listRobots]);
        }

        return view('pages.teams', [
            'teamsWithPlayers' => $teamsWithPlayers,
            /*'id_place' => $id_place*/
        ]);
    }
}
