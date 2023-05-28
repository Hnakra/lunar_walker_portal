<?php

namespace App\Traits;

use App\Filters\Statistic\StatisticDateTournamentFilter;
use App\Filters\Statistic\StatisticTournamentFilter;
use App\Filters\Statistic\StatisticTournamentPlaceFilter;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;

trait TournamentsFilterLists
{
    private function getClassList(): array
    {
        return [
            StatisticDateTournamentFilter::class,
            StatisticTournamentFilter::class,
            StatisticTournamentPlaceFilter::class
        ];
    }

    private function getListFiltersByDate(): array
    {
        return array_unique(
            array_map(fn($item) => explode(" ", $item)[0], Tournament::pluck('date_time')->all())
        );
    }

    private function getListFiltersByTournaments(): array
    {
        return array_unique(
            Tournament::pluck('name')->all()
        );
    }
    private function getListFiltersByPlaceNames(): array
    {
        return array_unique(
            Tournament::leftJoin('places', 'tournaments.id_place', '=', 'places.id')
                ->get()->pluck('name')->all(),
        );
    }

}
