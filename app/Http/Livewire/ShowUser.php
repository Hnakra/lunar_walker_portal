<?php

namespace App\Http\Livewire;

use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $robots = [], $user, $teams = [], $team;

    public function createShowModal(){
        $this->robots = Robot::where("id_master",$this->user->id)->get();
        $this->teams = Team::where("name",$this->user->id)->get();
        $this->modalFormVisible = true;
    }

    public function render()
    {
        return view('livewire.show-user');
    }
}
