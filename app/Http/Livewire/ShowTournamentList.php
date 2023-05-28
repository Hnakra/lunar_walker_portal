<?php

namespace App\Http\Livewire;

use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Traits\Filter;
use App\Traits\TournamentsFilterLists;

class ShowTournamentList extends Component
{
    use Filter;
    use TournamentsFilterLists;

    public $tournaments;

    public function refresh()
    {
        $filter = function ($query) {
            $this->filter(
                $query,
                $this->getClassList(),
                fn() => [
                    'date' => $this->getListFiltersByDate(),
                    'tournamentName' => $this->getListFiltersByTournaments(),
                    'placeName' => $this->getListFiltersByPlaceNames(),
                ]);
        };
        $this->tournaments = Tournament::select(DB::raw('tournaments.* , places.name as placeName'))
            ->leftJoin('places', 'tournaments.id_place', '=', 'places.id')
            ->where($filter)->orderBy('date_time', 'desc')->get();
    }

    public function render()
    {
        $this->refresh();
        return view('livewire.show-tournament-list', [
            'tournaments' => $this->tournaments
        ]);
    }
}
