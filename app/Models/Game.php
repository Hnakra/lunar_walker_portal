<?php

namespace App\Models;

use DateTime;
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

    public function groupName()
    {
        return TeamsInTournament::where("id_team", $this->id_team_1)
            ->where("id_tournament", $this->id_tournament)->get()->first()
            ->groupName();
    }

    public function team_1()
    {
        return $this->hasOne(Team::class, 'id', 'id_team_1');
    }

    public function team_2()
    {
        return $this->hasOne(Team::class, 'id', 'id_team_2');
    }

    public static function getGamesWithTeams($condition = null, $filterCallable = null)
    {
        return Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))
            ->where($condition)
            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->where($filterCallable)
            ->orderBy('date_time', 'desc');
    }

    public function getTime()
    {
        $time = explode(' ', $this->date_time)[1];
        $timeParts = explode(':', $time);
        return "$timeParts[0]:$timeParts[1]";
    }

    public function getDateTimeAttribute(): string
    {
        return (new DateTime($this->attributes['date_time']))->format('Y-m-d H:i');
    }

    public function comparsionTeamsCount($reverse = false): ?int
    {
        if ($reverse) {
            return $this->id_state === 0 ? ($this->count_team_2 <=> $this->count_team_1) : null;
        } else {
            return $this->id_state === 0 ? ($this->count_team_1 <=> $this->count_team_2) : null;
        }
    }
}
