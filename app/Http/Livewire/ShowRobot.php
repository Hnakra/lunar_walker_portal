<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class ShowRobot, класс отображения модального окна с данными робота
 * @package App\Http\Livewire
 */
class ShowRobot extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $robot, $user;
    // метод получения данных и вызов модального окна
    public function createShowModal(){
        $this->user = User::find($this->robot->id_master);
        $this->robot->photo = is_readable("storage/robots/{$this->robot->id}/{$this->robot->img}") ? "../storage/robots/{$this->robot->id}/{$this->robot->img}" : "https://ui-avatars.com/api/?name=".$this->robot->name."&color=7F9CF5&background=EBF4FF";

        $this->modalFormVisible = true;
    }

    public function render()
    {
        return view('livewire.show-robot');
    }
}
