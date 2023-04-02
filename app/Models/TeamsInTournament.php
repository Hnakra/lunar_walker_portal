<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TeamsInTournament
 * @package App\Models
 * @property integer id
 * @property integer id_tournament
 * @property integer id_team
 * @property integer group
 */
class TeamsInTournament extends Model
{
    protected $table = "teams_in_tournaments";
    use HasFactory;

    public static function findByIDS($selectedTeamsIds, $id_tournament)
    {
        return collect($selectedTeamsIds)
            ->map(fn($id) => TeamsInTournament::where("id_tournament", $id_tournament)
                ->where("id_team", $id)->get()->first()
            );
    }
    public function groupName(){
        return range('A', 'Z')[$this->attributes['group']-1];
    }
}
