<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // protected $appends = ['groupName'];
    public function groupName()
    {
        return isset($this->attributes['group']) ?
            range('A', 'Z')[$this->attributes['group'] - 1] :
            null;
    }

    public function isPickedInPlayoff($idPlayoff): bool
    {
        $tournament = Tournament::find($idPlayoff);
        $gamesIds = $tournament->games->pluck('id_team_1')->merge($tournament->games->pluck('id_team_2'));
        $isPicked = $tournament->is_playoff && $gamesIds->contains($this->id_team ?? $this->id);
        return $isPicked;
    }

}
