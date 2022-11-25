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
        if(Auth::user()->isUser()){
            $tournaments = $this->getUserData();
        }
        if(Auth::user()->isAdmin()){
            $tournaments = $this->getAdminData();
        }

        return view('pages.tournaments',[
            'tournaments' => $tournaments
        ]);
    }

    /**
     * Метод, срабатывающий, когда пользователь подтверждает участие в турнире
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submit(){
        DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->update(['is_submit' => true]);
        return redirect('/tournaments');
    }
    /**
     * Метод, возвращающий данные о том, в каких турнирах и в числе каких команд участвует пользователь для подтверждения своего участия
     * @return array
     */
    private function getUserData(){
        $tournaments_with_user = DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->get();
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
        }
        return $tournaments;
    }

    /**
     * Метод, возвращающие данные о том, какие турниры и какие команды есть в системе для подтверждения своего участия
     * @return Tournament[]|\LaravelIdea\Helper\App\Models\_IH_Tournament_C
     */
    private function getAdminData(){
        $tournaments = Tournament::select(DB::raw("tournaments.*, places.name as placeName"))
            ->leftJoin('places', "places.id", '=', 'tournaments.id_place')
            ->get();
        $i=0;
        foreach($tournaments as $t){
            $tournaments[$i]['teams'] = DB::table('teams_in_tournaments')
                ->where('id_tournament', $t->id)
                ->leftJoin('teams', "teams_in_tournaments.id_team", '=', 'teams.id')
                ->get();
            foreach ($tournaments[$i]['teams'] as $team){
                $team->players = Player::select(DB::raw("users.*, submit_tournaments.is_submit as is_submit"))
                    ->where('players.id_team', $team->id)
                    ->where('submit_tournaments.id_tournament', $t->id)
                    ->leftJoin('users', 'players.id_user', '=', 'users.id')
                    ->leftJoin('submit_tournaments', 'submit_tournaments.id_user', '=', 'users.id')
                    ->get();
            }
            $i++;
        }
        return $tournaments;
    }

}
