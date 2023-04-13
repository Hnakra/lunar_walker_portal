<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowFreshGamesStatistic extends Component
{
    public $freshGames;
    public function refresh(){
        $condition = function ($query){
            $query->where('id_state', '>', 0);
        };
        $this->freshGames = Game::getGamesWithTeams($condition)->get();

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
