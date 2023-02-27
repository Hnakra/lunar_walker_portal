<?php

namespace App\Http\Livewire;

use App\Filters\Statistic\StatisticDateFilter;
use App\Filters\Statistic\StatisticTeamFilter;
use App\Filters\Statistic\StatisticTournamentFilter;
use App\Models\Game;
use App\Traits\Filter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowStatistics extends Component
{
    use Filter;
    public $freshGames, $games;
    public $batch = 20, $step_batch = 20;

    public function load_more(){
        $this->batch += $this->step_batch;
        $this->refresh();
    }
    private function getSelectValuesByKey($keys, $state = false): array
    {
        $arrays = array_map(fn($k)=> $this->games->pluck($k)->all(),$keys);
        $values = array_unique(array_merge(...$arrays));
        return array_combine($values, array_fill(0, count($values), $state));
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

        $this->filter($this->games, [
                'date' => [
                    'data' => $this->getSelectValuesByKey(['date']),
                    'class' => StatisticDateFilter::class
                ],
                'tournamentName' => [
                    'data' => $this->getSelectValuesByKey(['tournamentName']),
                    'class' => StatisticTournamentFilter::class
                ],
                'team' => [
                    'data' => $this->getSelectValuesByKey(['t1_name', 't2_name']),
                    'class' => StatisticTeamFilter::class
                ]
            ]
        );

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
