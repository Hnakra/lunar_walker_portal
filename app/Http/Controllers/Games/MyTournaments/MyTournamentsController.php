<?php

namespace App\Http\Controllers\Games\MyTournaments;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class MyTournamentsController, получает данные и выводит их на странице Мои игры
 * @package App\Http\Controllers\Games\MyTournaments
 */
class MyTournamentsController extends Controller
{
    public function index(){
        $tournaments = [];

        if(Auth::user()->isAdmin()||Auth::user()->isOrganizer()||Auth::user()->isTrainer()){
            $tournaments = $this->getAdminData();
        }
        else{
            $tournaments = $this->getUserData();
        }

        return view('pages.tournaments',[
            'tournaments' => $tournaments
        ]);
    }

    /**
     * Метод, срабатывающий, когда пользователь подтверждает участие в турнире
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submit($id_tournament, $id_team){
        DB::table('submit_tournaments')
            ->insert([
                'id_tournament' => $id_tournament,
                'id_team' => $id_team,
                'id_user' => Auth::user()->id,
                'is_submit' => true,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
        //DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->update(['is_submit' => true]);
        return redirect('/tournaments');
    }
    /**
     * Метод, возвращающий данные о том, в каких турнирах и в числе каких команд участвует пользователь для подтверждения своего участия
     * @return array
     */

    private function getUserData(){
        $tournaments = DB::table('tournaments')
            ->select(DB::raw('
                tournaments.id as tournamentId,
                tournaments.name as tournamentName,
                tournaments.date_time as date_time,
                places.name as placeName,
                teams.name as teamName,
                teams.id as teamId
            '))
            ->join('teams_in_tournaments', 'teams_in_tournaments.id_tournament', '=', 'tournaments.id')
            ->join('players', 'players.id_team', '=', 'teams_in_tournaments.id_team')
            ->leftJoin('places', 'places.id', '=', 'tournaments.id_place')
            ->leftJoin('teams', 'teams.id', '=', 'teams_in_tournaments.id_team')
            ->where('id_user', Auth::user()->id)
            ->get();
        foreach ($tournaments as $tournament){
            $tournament->players = Player::where('id_team', $tournament->teamId)
                ->leftJoin('users', 'users.id', '=', 'players.id_user')
                ->get();
            foreach ($tournament->players as $player) {
                $player->is_submit = DB::table('submit_tournaments')
                    ->where('id_tournament', $tournament->tournamentId)
                    ->where('id_team', $tournament->teamId)
                    ->where('id_user', $player->id_user)->get()->isNotEmpty();
                if($player->id == Auth::user()->id){
                    $tournament -> is_submit = $player->is_submit;
                }
            }

        }
        // $tournaments = $this->unique_multidim_array($tournaments,'id_tournament');
/*        $tournaments_with_user = DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->get();
        $tournaments = [];
        $i = 0;
        foreach ($tournaments_with_user as $t) {
            $tournaments[$i]['team'] = Player::select(DB::raw("teams.name as teamName, submit_tournaments.is_submit, users.*"))
                ->where('players.id_team', $t->id_team)
                ->leftJoin('teams', "players.id_team", '=', 'teams.id')
                ->leftJoin('users', 'players.id_user', '=', 'users.id')
                ->leftJoin('submit_tournaments', 'submit_tournaments.id_user', '=', 'players.id_user')
                ->get();
            $tournaments[$i]['info'] = Tournament::select(DB::raw("places.name as placeName, tournaments.*"))
                ->where('tournaments.id', $t->id_tournament)
                ->leftJoin('places', "places.id", '=', 'tournaments.id_place')
                ->get()->first();
            $tournaments[$i]['is_submit'] = $t->is_submit;
            $i++;
        }*/
        return $tournaments;
    }

    /**
     * Метод, возвращающие данные о том, какие турниры и какие команды есть в системе для подтверждения своего участия
     * @return Tournament[]|\LaravelIdea\Helper\App\Models\_IH_Tournament_C
     */
    private function getAdminData()
    {
        $tournaments = Tournament::select(DB::raw("tournaments.*, places.name as placeName"))
            ->leftJoin('places', "places.id", '=', 'tournaments.id_place')
            ->get();
        $i = 0;
        foreach ($tournaments as $t) {
            $tournaments[$i]['teams'] = DB::table('teams_in_tournaments')
                ->where('id_tournament', $t->id)
                ->leftJoin('teams', "teams_in_tournaments.id_team", '=', 'teams.id')
                ->get();
            foreach ($tournaments[$i]['teams'] as $team) {
                $team->players = Player::select(DB::raw("users.*"))
                    ->where('players.id_team', $team->id)
                    ->leftJoin('users', 'players.id_user', '=', 'users.id')
                    ->get();
                foreach ($team->players as $player) {
                    $player->is_submit = DB::table('submit_tournaments')
                        ->where('id_tournament', $t->id)
                        ->where('id_team', $team->id)
                        ->where('id_user', $player->id)
                        ->get()->isNotEmpty();
                }
            }
            $i++;
        }
        return $tournaments;
    }
/*    // метод, возращающий массив без повторений в конкретном поле
    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val->$key, $key_array)) {
                $key_array[$i] = $val->$key;
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }*/
}
