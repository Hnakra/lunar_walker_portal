<?php

namespace App\Http\Livewire;

use App\Models\Place;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddTournament extends Component
{
//    Переменная открытия-закрытия формы
    public $modalFormVisible = false;
//    Переменные формы
    public $name, $id_place, $description, $date, $time, $selected_teams_id = [];
//    Переменные отображения
    public $places = [], $teams = [];

    public function createShowModal(){
        $this->places = Place::all();
        $this->teams = Team::all();
        $this->modalFormVisible = true;
    }
    public function submitShowModal(){
        $id_tournament = DB::table('tournaments')->insertGetId([
            'name'=> $this->name,
            'description' => $this->description,
            'date_time' => "$this->date $this->time",
            'id_place' => $this->id_place,
            'id_creator' => Auth::user()->id,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        foreach ($this->selected_teams_id as $team_id){
            DB::table('teams_in_tournaments')->insert([
                'id_tournament' => $id_tournament,
                'id_team' => $team_id,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
        }
        $this->modalFormVisible = true;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);

    }
    public function addTeam(){
        array_push($this->selected_teams_id, 0);
    }
    public function removeTeam($index){
        unset($this->selected_teams_id[$index]);
    }
    public function render()
    {
        return view('livewire.add-tournament');
    }
}
