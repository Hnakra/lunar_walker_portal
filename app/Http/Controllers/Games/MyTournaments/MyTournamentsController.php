<?php

namespace App\Http\Controllers\Games\MyTournaments;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyTournamentsController extends Controller
{
    public function index(){
        // узнаем, в каких турнирах и в числе каких команд участвует пользователь
        $tournaments_with_user = DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->get();
        $tournaments = [];
        $i = 0;
        foreach ($tournaments_with_user as $t){
            $tournaments[$i]['team'] = Player::select(DB::raw("teams.name as teamName, submit_tournaments.is_submit, users.*" ))
                ->where('players.id_team', $t->id_team)
                ->leftJoin('teams', "players.id_team", '=', 'teams.id')
                ->leftJoin('users', 'players.id_user','=', 'users.id')
                ->leftJoin('submit_tournaments', 'submit_tournaments.id_user','=', 'players.id_user')
                ->get();
            $tournaments[$i]['info'] = Tournament::select(DB::raw("places.name as placeName, tournaments.*" ))
                ->where('tournaments.id', $t->id_tournament)
                ->leftJoin('places', "places.id", '=', 'tournaments.id_place')
                ->get()->first();
            $tournaments[$i]['is_submit'] = $t->is_submit;
            $i++;
        }


        return view('pages.tournaments',[
            'tournaments' => $tournaments
        ]);
    }
    public function submit(){
        DB::table('submit_tournaments')->where("id_user", Auth::user()->id)->update(['is_submit' => true]);
        return redirect('/tournaments');
    }
}
