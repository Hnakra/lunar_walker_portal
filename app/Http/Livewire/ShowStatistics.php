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
    public $freshGames, $games, $filterParams;
    public $batch = 20, $step_batch = 20;

    public function load_more(){
        $this->batch += $this->step_batch;
        $this->refresh();
    }
    private function getSelectValuesByKey($values, $state = false): array
    {
        return array_combine($values, array_fill(0, count($values), $state));
    }
    public function refresh(){
        $this->games = Game::select(DB::raw('games.* , T1.name as t1_name, T2.name as t2_name, tournaments.name as tournamentName'))
            ->where('id_state', 0)
            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
            ->where(function($query){
                $this->filter($query);
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
        if(!isset($this->filter_params)) {
            $this->filter_params = [
                'date' => [
                    'data' => $this->getSelectValuesByKey(array_unique(
                        array_map(fn($item) => explode(" ", $item)[0], Game::where('id_state', 0)->get()->pluck('date_time')->all())
                    )),
                    'class' => StatisticDateFilter::class
                ],
                'tournamentName' => [
                    'data' => $this->getSelectValuesByKey(array_unique(
                        Game::select(DB::raw('games.* , tournaments.name as tournamentName'))
                            ->where('id_state', 0)
                            ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
                            ->get()->pluck('tournamentName')->all()
                    )),
                    'class' => StatisticTournamentFilter::class
                ],
                'team' => [
                    'data' => $this->getSelectValuesByKey(array_unique(array_merge(
                        Game::select(DB::raw('games.* , T1.name as t1_name'))
                            ->where('id_state', 0)
                            ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
                            ->get()->pluck('t1_name')->all(),
                        Game::select(DB::raw('games.* , T2.name as t2_name'))
                            ->where('id_state', 0)
                            ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
                            ->get()->pluck('t2_name')->all()
                    ))),
                    'class' => StatisticTeamFilter::class
                ]
            ];
        }
        $this->initFilter($this->filter_params);
        $this->refresh();
        return view('livewire.show-statistics');
    }
}
