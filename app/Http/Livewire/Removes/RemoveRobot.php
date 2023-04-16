<?php

namespace App\Http\Livewire\Removes;

use App\Models\Robot;
use Livewire\Component;

class RemoveRobot extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменная id робота, которого требуется удалить

    public $current_robot;
    // метод открытия модального окна

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    // метод удаления сущности, редирект

    public function remove(){
        Robot::where("id", $this->current_robot)->delete();
        $this->modalFormVisible = false;
        redirect("/robots", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.removes.remove-robot');
    }
}
