<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowFreshGamesStatistic extends Component
{
    public $freshGames;
    public function refresh(){
        $this->freshGames = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))
            ->where('id_state', '>', 0)
            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->orderBy('date_time', 'desc')
            ->get();
        foreach ($this->freshGames as $game){
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }
    }
    public function render()
    {
        $this->refresh();
        return view('livewire.show-fresh-games-statistic');
    }
}
