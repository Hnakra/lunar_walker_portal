<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    public function isGrouped(): bool
    {
        return $this->numGroups() > 1;
    }
    public function numGroups(){
        return TeamsInTournament::where('id_tournament', $this->id)
            ->distinct('group')->count('group');
    }
/*    public function teams(){
        return $this->belongsToMany(Team::class, 'teams_in_tournaments', 'id_tournament', 'id_team');
    }*/
}
