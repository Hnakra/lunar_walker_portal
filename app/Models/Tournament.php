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

    public function numGroups()
    {
        return TeamsInTournament::where('id_tournament', $this->id)
            ->distinct('group')->count('group');
    }

    public function getTeamsByGroupId($id_group)
    {
        return TeamsInTournament::where('id_tournament', $this->id)->where('group', $id_group)
            ->leftJoin('teams', 'teams_in_tournaments.id_team', '=', 'teams.id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany(Game::class, 'id_tournament');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'id_place');
    }
    /*    public function teamsInTournaments(){
            return $this->hasOne(TeamsInTournament::class, 'id_tournament');
        }*/

    /*    public function teams(){
            return $this->belongsToMany(Team::class, 'teams_in_tournaments', 'id_tournament', 'id_team');
        }*/
}
