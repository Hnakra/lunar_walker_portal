<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\TeamsInTournament;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GroupTeamsInTournament extends Component
{
    public $modalFormVisible = false;
    public $id_tournament;
    public $MAX_NUM_GROUPS = 5, $numGroups = 1, $groupingType = "auto";

    public Collection $teams;
    public \Illuminate\Support\Collection $teamGroup;

    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function submitShowModal()
    {
        if ($this->numGroups > 1) {
            $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
                ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
                ->get();
            if ($this->groupingType == "manual") {
                $this->validate([
                    'teamGroup.*' => 'required|not_in:0',
                    // закомментированная валидация на то, чтобы команд в группе было больше 1
                    /*'teamGroup' =>
                        function ($attribute, $value, $fail) {
                            $teamGroup = collect($value);
                            foreach ($teamGroup->unique()->values()->toArray() as $v){
                                $filteredByGroup = $teamGroup->filter(fn($item)=> $item == $v);
                                if($filteredByGroup->count() == 1){
                                    $teamName = Team::find($filteredByGroup->keys()->first())->name;
                                    $fail("Команда \"$teamName\" не может играть одна!");
                                }
                            }
                        }*/
                ],
                    ['teamGroup.*.not_in' => 'Все команды должны состоять в группах!']);
            } else {
                $ids = new \Illuminate\Support\Collection($this->teams->pluck('id_team'));
                $values = array_map(fn($item) => $item % $this->numGroups + 1, range(0, $ids->count() - 1));
                shuffle($values);
                $this->teamGroup = $ids->combine($values);
            }

            for ($i = 1; $i <= $this->numGroups; $i++) {
                $selectedTeamsIds = $this->teamGroup->filter(fn($item) => $item == $i)->keys()->all();
                $selectedTeams = TeamsInTournament::findByIDS($selectedTeamsIds, $this->id_tournament);
                $selectedTeams->each(function ($item) use ($i) {
                    $item->group = $i;
                    $item->save();
                });
            }

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
            $tournament = Tournament::find($this->id_tournament);
            if ($tournament->isGrouped()) {
                $this->groupingType = "manual";
                $this->numGroups = $tournament->numGroups();
                $groups = $this->teams->pluck('group');
            } else {
                $groups = array_fill(0, $ids->count(), 0);
            }

            $this->teamGroup = $ids->combine($groups);
        }

        return view('livewire.group-teams-in-tournament');
    }
}
