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
    public $freshGames, $games, $filterParams;
    public $batch = 20, $step_batch = 20;

    public function load_more(){
        $this->batch += $this->step_batch;
        $this->refresh();
    }
    public function refresh(){
        $this->games = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))
            ->where('id_state', 0)
            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->where(function($query){
                $this->filter($query, $this->getClassList(), fn() => [
                    'date' => $this->getListFiltersByDate(),
                    'tournamentName' => $this->getListFiltersByTournaments(),
                    'team' => $this->getListFiltersByTeams()
                ]);
            })
            ->orderBy('date_time', 'desc')
            ->limit($this->batch)->get();
        foreach ($this->games as $game) {
            list($game->date, $game->time) = explode(" ", $game->date_time);
        }

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
        return view('livewire.show-statistics');
    }
}
