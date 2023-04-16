<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CounterLog extends Model
{
    use HasFactory;
    public static function getByGameId($game_id){
        $logs = DB::table('counter_log')->select(DB::raw('counter_log.* , teams.name'))
            ->where("counter_log.id_game", $game_id)
            ->leftJoin('teams', 'counter_log.id_team', '=', 'teams.id')
            ->orderBy('counter_log.id', 'desc')->get();
        foreach ($logs as $log) {
            list($log->date, $log->time) = explode(" ", $log->created_at);
        }
        return $logs;
    }
}
