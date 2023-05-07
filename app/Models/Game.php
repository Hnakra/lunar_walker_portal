<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $fillable = [
        'id_tournament',
        'id_team_1',
        'id_team_2',
        'count_team_1',
        'count_team_2',
        'date_time',
        'max_seconds_match',
        'datetime_state'
    ];
    use HasFactory;
    public function groupName(){
        return TeamsInTournament::where("id_team", $this->id_team_1)
            ->where("id_tournament", $this->id_tournament)->get()->first()
            ->groupName();
    }

    public function team_1(){
        return $this->hasOne(Team::class,  'id', 'id_team_1');
    }
    public function team_2(){
        return $this->hasOne(Team::class, 'id','id_team_2');
    }
    public static function getGamesWithTeams($condition = null, $filterCallable = null){
        return Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))
            ->where($condition)
            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->where($filterCallable)
            ->orderBy('date_time', 'desc');
    }
}
