<?php

namespace App\Http\Livewire;

use App\Models\Robot;
use Livewire\Component;

class RemoveRobot extends Component
{
    public $modalFormVisible = false;
    public $current_robot;

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    public function remove(){
        Robot::where("id", $this->current_robot)->delete();
        $this->modalFormVisible = false;
        redirect("/robots", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.remove-robot');
    }
}
