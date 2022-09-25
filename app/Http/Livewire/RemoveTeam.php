<?php

namespace App\Http\Livewire;

use App\Models\Player;
use App\Models\Team;
use Livewire\Component;

class RemoveTeam extends Component
{
    public $modalFormVisible = false;
    public $current_team, $id_place;

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    public function remove(){
        Team::where("id", $this->current_team)->delete();
        Player::where("id_team", $this->current_team)->delete();
        $this->modalFormVisible = false;
        redirect("/places/$this->id_place/teams", [\App\Http\Controllers\TeamsController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.remove-team');
    }
}
