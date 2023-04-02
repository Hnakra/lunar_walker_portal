<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return TeamsInTournament::find($this->id_team_1)->groupName();
    }
}
