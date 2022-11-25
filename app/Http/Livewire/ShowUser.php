<?php

namespace App\Http\Livewire;

use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class ShowUser, класс отображения модального окна с данными пользователя
 * @package App\Http\Livewire
 */
class ShowUser extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $robots = [], $user, $teams = [], $team;
    // метод получения данных и вызов модального окна
    public function createShowModal(){
        $this->user->photo = ($this->user->profile_photo_path != null && is_readable("storage/{$this->user->profile_photo_path}")  ) ? "../storage/{$this->user->profile_photo_path}" : "https://ui-avatars.com/api/?name=".$this->user->name."&color=7F9CF5&background=EBF4FF";
        $this->robots = Robot::where("id_master",$this->user->id)->get();
        $this->teams = DB::table('players')->select('teams.*')
            ->where("players.id_user",$this->user->id)
            ->leftJoin('teams', 'teams.id', '=', 'players.id_team')
            ->get();
        $this->user->initials = explode(" ", $this->user->name);
        $this->modalFormVisible = true;
    }
    public function closeModal(){
        $this->teams = [];
        $this->modalFormVisible = false;

    }

    public function render()
    {
        return view('livewire.show-user');
    }
}
