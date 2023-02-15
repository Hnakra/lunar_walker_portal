<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowStatistics extends Component
{
    public $freshGames, $games;
    public $selectedDropdowns = [];
    public $filter = ['date'=>[], 'tournament'=>[], 'team'=>[]];
    public $batch = 20, $step_batch = 20;

    public function show_dropdown($dropdown_name){
        if (!in_array($dropdown_name, $this->selectedDropdowns)){
            array_push($this->selectedDropdowns, $dropdown_name);
        }
    }
    public function close_dropdown($dropdown_name){
        unset($this->selectedDropdowns[array_search($dropdown_name,$this->selectedDropdowns)]);
    }

    public function load_more(){
        $this->batch += $this->step_batch;
        $this->refresh();
    }
    public function refresh(){
        $this->games = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))->
        where('id_state', 0)->
        leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')->
        leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')->
        leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')->
        limit($this->batch)->get()->sortByDesc('updated_at');
        foreach ($this->games as $game) {
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }

        $this->freshGames = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))->
        where('id_state', '>', 0)->
        leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')->
        leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')->
        leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')->
        get()->sortByDesc('updated_at');
        foreach ($this->freshGames as $game){
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }
    }
    public function render()
    {
        $this->refresh();
        return view('livewire.show-statistics');
    }
}
