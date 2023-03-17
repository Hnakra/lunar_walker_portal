<?php
namespace App\Traits\TournamentsTable;
use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

trait AddTournamentsTable
{
    //private int $interval, $max_seconds_match;

    private function makeGames($selectedTable, $teams)
    {
        switch ($selectedTable) {
            case 'all_vs_all':
                $this->all_vs_all_generate($teams);
                break;
        }
    }

    private function all_vs_all_generate($teams)
    {
        $games = [];
        for ($i = 0; $i < $teams->count(); $i++) {
            for ($j = $i+1; $j < $teams->count(); $j++) {
                array_push($games, [$teams->get($i)->id_team, $teams->get($j)->id_team]);
            }
        }
        shuffle($games);
        foreach ($games as $k => $game){

            // $group = $this->generateNumberOfGroup($k);
            $tournament = Tournament::find($this->id_tournament);
            $tournament->isGenerated = true;
            $tournament->save();

            Game::create([
                'id_tournament' => $this->id_tournament,
                'id_team_1' => $game[0],
                'id_team_2' => $game[1],
                'count_team_1' => 0,
                'count_team_2' => 0,
                'date_time' => date("Y-m-d H:i:s", strtotime($tournament->date_time)+$this->interval*60*$k),
                'max_seconds_match' => $this->max_seconds_match,
                'datetime_state' => date("Y-m-d H:i:s", 0)
            ]);
        }

    }
}
