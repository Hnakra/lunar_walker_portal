<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Traits\TournamentsTable\AddTournamentsTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddTournamentTable extends Component
{
    use AddTournamentsTable;
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    public $id_tournament;
    public $listTables = ['all_vs_all'=>"Все со всеми"], $selectedTable;
    public $interval = 10, $max_seconds_match = 300;
    public $MAX_NUM_GROUPS=5, $numGroups = 1, $groupingType="auto";
    public Collection $teams;
    public \Illuminate\Support\Collection $teamGroup;

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
        if($this->numGroups > 1){
            $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
                ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
                ->get();
            if ($this->groupingType == "manual"){
/*                Validator::make(
                    ['teamGroup' => $this->teamGroup],
                    ['teamGroup.*' => 'required|not_in:0'],
                    ['required' => 'кудах']
                )->validate();*/

                $this->validate([
                    'teamGroup.*' => 'required|not_in:0',
                    'teamGroup' =>
                        function ($attribute, $value, $fail) {
                            $teamGroup = collect($value);
                            foreach ($teamGroup->unique()->values()->toArray() as $v){
                                $filteredByGroup = $teamGroup->filter(fn($item)=> $item == $v);
                                if($filteredByGroup->count() == 1){
                                    $teamName = Team::find($filteredByGroup->keys()->first())->name;
                                    $fail("Команда \"$teamName\" не может играть одна!");
                                }
                            }
                        }
                ]);
            } else {
                $ids = new \Illuminate\Support\Collection($this->teams->pluck('id_team'));
                $values = array_map(fn($item) => $item%$this->numGroups+1, range(0, $ids->count()-1));
                shuffle($values);
                $this->teamGroup = $ids->combine($values);
            }

            for($i = 1; $i <= $this->numGroups; $i++){
                $selectedTeamsIds = $this->teamGroup->filter(fn($item)=> $item == $i)->keys()->all();

                $this->makeGames(
                    $this->selectedTable,
                    $this->teams->whereIn("id_team", $selectedTeamsIds));

                // dd($selectedTeamsIds, $this->teams->whereIn("id_team", $selectedTeamsIds));
            }

        } else{
            $this->makeGames($this->selectedTable, $this->teams);
        }
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {

        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
            ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
            ->get();

        if (!isset($this->teamGroup)) {
            $ids = new \Illuminate\Support\Collection($this->teams->pluck('id_team'));
            $zeros = array_fill(0, $ids->count(), 0);
            $this->teamGroup = $ids->combine($zeros);
        }

        return view('livewire.add-tournament-table');
    }
}
