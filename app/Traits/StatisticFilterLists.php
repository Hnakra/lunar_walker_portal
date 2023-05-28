<?php
namespace App\Traits;
use App\Filters\Statistic\StatisticDateTournamentFilter;
use App\Filters\Statistic\StatisticTeamFilter;
use App\Filters\Statistic\StatisticTournamentFilter;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

trait StatisticFilterLists{
    private function getClassList(): array{
        return [
            StatisticDateTournamentFilter::class,
            StatisticTournamentFilter::class,
            StatisticTeamFilter::class
        ];
    }
    private function getListFiltersByDate(): array
    {
        return array_unique(
            array_map(fn($item) => explode(" ", $item)[0], Game::where('id_state', 0)->get()->pluck('date_time')->all())
        );
    }
    private function getListFiltersByTournaments(): array
    {
        return array_unique(
            Game::select(DB::raw('games.* , tournaments.name as tournamentName'))
                ->where('id_state', 0)
                ->leftJoin('tournaments', 'games.id_tournament', '=', 'tournaments.id')
                ->get()->pluck('tournamentName')->all()
        );
    }
    private function getListFiltersByTeams(): array
    {
        return array_unique(array_merge(
            Game::select(DB::raw('games.* , T1.name as t1_name'))
                ->where('id_state', 0)
                ->leftJoin('teams as T1', 'games.id_team_1', '=', 'T1.id')
                ->get()->pluck('t1_name')->all(),
            Game::select(DB::raw('games.* , T2.name as t2_name'))
                ->where('id_state', 0)
                ->leftJoin('teams as T2', 'games.id_team_2', '=', 'T2.id')
                ->get()->pluck('t2_name')->all()
        ));
    }
}
