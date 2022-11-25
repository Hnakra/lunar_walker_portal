<?php

namespace App\Http\Livewire;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveTeam extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменная id команды, которую требуется удалить
    public $current_team;
    // переменная отображения ошибки на случай, если удаление невозможно
    public $errorMessage = "";
    // метод открытия модального окна

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    // метод удаления сущности, редирект

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
