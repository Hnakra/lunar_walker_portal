<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Traits\Filter;
use App\Traits\StatisticFilterLists;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowStatistics extends Component
{
    use Filter;
    use StatisticFilterLists;
    public $freshGames, $games;
    public $batch = 20, $step_batch = 20;

    public function load_more(){
        $this->batch += $this->step_batch;
        $this->refresh();
    }
    public function refresh(){
        $filter = function($query){
            $this->filter($query, $this->getClassList(), fn() => [
                'date' => $this->getListFiltersByDate(),
                'tournamentName' => $this->getListFiltersByTournaments(),
                'team' => $this->getListFiltersByTeams()
            ]);
        };
        $condition = function ($query){
            $query->where('id_state', 0);
        };
        $this->games = Game::getGamesWithTeams($condition, $filter)->limit($this->batch)->get();

        foreach ($this->games as $game) {
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }
    }

    public function render()
    {
        $this->refresh();
        return view('livewire.show-statistics');
    }
}
