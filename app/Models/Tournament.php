<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TournamentsTable\AddTournamentsTable;

class Tournament extends Model
{
    use HasFactory;
    use AddTournamentsTable;

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

    public function getDateTimeAttribute(): string
    {
        return (new DateTime($this->attributes['date_time']))->format('Y-m-d H:i');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'teams_in_tournaments', 'id_tournament', 'id_team');
    }

    public function isDoneAllVsAll(): bool
    {
        return $this->games->every(fn($game) => $game->id_state === 0) && self::checkAllVSAll($this);
    }

    public function isFilledPlayoff(): bool
    {
        if(!$this->is_playoff){
            return false;
        }

        foreach ($this->teams as $team) {

            if (!$team->isPickedInPlayoff($this->id)) {
                return false;
            }
        }

        return true;
    }

    public function isDonePlayoff(): bool
    {
        return $this->isFilledPlayoff() && $this->games->every(fn($game) => $game->id_state === 0);
    }
}
