<?php

namespace App\Http\Livewire;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveTeam extends Component
{
    public $modalFormVisible = false;
    public $current_team, $id_place;
    public $errorMessage = "";

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    public function remove(){
        if (DB::table('teams_in_tournaments')->where("id_team", $this->current_team)->get()->isEmpty()){

            Team::where("id", $this->current_team)->delete();
        Player::where("id_team", $this->current_team)->delete();
        $this->modalFormVisible = false;
        redirect("/teams", [\App\Http\Controllers\Teams\TeamsController::class, 'index']);
        }
        else{
            $this->errorMessage = "Есть турниры, на которых играет данная команда!";
        }
    }

    public function render()
    {
        return view('livewire.remove-team');
    }
}
