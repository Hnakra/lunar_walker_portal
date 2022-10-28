<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowRobot extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $robot, $user;

    public function createShowModal(){
        $this->user = User::find($this->robot->id_master);
//        $user = User::where('id', $this->robot->id_master)->get()->first();
//        $user = DB::table('users')->where('id', $this->robot->id_master)->get()->first();
        $this->modalFormVisible = true;
    }

    public function render()
    {
        return view('livewire.show-robot');
    }
}
