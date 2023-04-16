<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\TeamsInTournament;
use App\Models\Tournament;
use App\Traits\TournamentsTable\AddTournamentsTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TournamentTableForm extends Component
{
    use AddTournamentsTable;
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    public $id_tournament;
    public $listTables = ['all_vs_all'=>"Все со всеми"], $selectedTable;
    public $interval = 10, $max_seconds_match = 300;

    public Collection $teams;

    protected $rules = [
        'selectedTable' => 'required'
    ];
    protected $messages = [
        'selectedTable.required' => 'Выберите способ генерации игр'
    ];

    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function submitShowModal(){
        $this->validate();
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
            ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
            ->get();
        $tournament = Tournament::find($this->id_tournament);
        $numGroups = $tournament->numGroups();
        for($i = 1; $i <= $numGroups; $i++){
            $teams = TeamsInTournament::where('id_tournament', $this->id_tournament)
                ->get()->filter(fn($team) => $team->group == $i);
            $this->makeGames($this->selectedTable, $teams);
        }

        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
            ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
            ->get();

        return view('livewire.tournament-table-form');
    }
}
