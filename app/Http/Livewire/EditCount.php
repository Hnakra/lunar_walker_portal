<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditCount extends Component
{
    public $game, $log;

    public function render()
    {
        $this->refresh();
        return view('livewire.edit-count');
    }

    public function plus($num_team)
    {
        if ($num_team == 1) {
            $this->game->count_team_1 = $this->game->count_team_1 + 1;
            $this->push_in_log($this->game->id_team_1, "+1");
        } else {
            $this->game->count_team_2 = $this->game->count_team_2 + 1;
            $this->push_in_log($this->game->id_team_2, "+1");
        }
        $this->game->save();
        $this->refresh();
    }

    public function minus($num_team)
    {
        if ($this->game->count_team_1 != 0 && $num_team == 1 || $this->game->count_team_2 != 0 && $num_team == 2) {
            if ($num_team == 1) {
                $this->game->count_team_1 = $this->game->count_team_1 - 1;
                $this->push_in_log($this->game->id_team_1, "-1");
            } else {
                $this->game->count_team_2 = $this->game->count_team_2 - 1;
                $this->push_in_log($this->game->id_team_2, "-1");
            }
            $this->game->save();
            $this->refresh();
        }
    }

    private function push_in_log($id_team, $difference)
    {
        DB::table('counter_log')->insert([
            'id_game' => $this->game->id,
            'id_team' => $id_team,
            'difference' => $difference,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
    }

    private function refresh()
    {
        $this->game = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name'))
            ->where('games.id', $this->game->id)
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->get()->first();
        $this->log = DB::table('counter_log')->select(DB::raw('counter_log.* , teams.name'))
            ->where("counter_log.id_game", $this->game->id)
            ->leftJoin('teams', 'counter_log.id_team', '=', 'teams.id')
            ->orderBy('counter_log.id', 'desc')->get();
        foreach ($this->log as $log) {
            list($log->date, $log->time) = explode(" ", $log->created_at);
        }
    }
}
