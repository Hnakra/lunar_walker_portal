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
            ->distinct()->count('group');
    }

    public function getTeamsByGroupId($id_group)
    {
        return TeamsInTournament::where('id_tournament', $this->id)->where('group', $id_group)
            ->leftJoin('teams', 'teams_in_tournaments.id_team', '=', 'teams.id')->get();
    }

    public function getGamesByGroupId($id_group)
    {
        $teamsIDS = $this->getTeamsByGroupId($id_group)->pluck('id_team');
        return Game::where('id_tournament', $this->id)->where(function ($query) use ($teamsIDS) {
            $query->whereIn('id_team_1', $teamsIDS)->orWhereIn('id_team_2', $teamsIDS)->get();
        })->get();
    }

    public function get_date(): string
    {
        return explode(' ', $this->date_time)[0];
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
