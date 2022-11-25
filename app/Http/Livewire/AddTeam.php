<?php

namespace App\Http\Livewire;

use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class AddTeam, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 */
class AddTeam extends Component
{
    //    Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $name, $selected_users_id = [];
    //    Переменные отображения
    public $users = [], $MAX_SELECTED_USERS = 5;
    // Переменная состояния, редактируется ли сущность (а также id сущности)
    public $current_team = 0;
    // Переменные отображения

    public $errorOutput;
    // Настройка правил валидации для формы
    protected $rules = [
       'name' => 'required|min:2',
       // 'name' => 'required|null'
        ];
    // метод вызова модельного окна для создания сущности

    public function createShowModal(){
        $this->users = User::all();
        $this->modalFormVisible = true;
    }
    // метод вызова модельного окна для изменения сущности
    public function editShowModal(){
        $this->users = User::all();
        $team = Team::where("id", $this->current_team)->get()->first();
        $this->selected_users_id = Player::where("id_team", $team->id)->pluck('id_user')->toArray();
        $this->name = $team->name;
        $this->modalFormVisible = true;
    }
    // метод добавления пользователя на форму
    public function addUser(){
        array_push($this->selected_users_id, 0);
    }
    // метод удаления пользователя с формы
    public function removeUser($index){
        unset($this->selected_users_id[$index]);
    }
    // метод сохранения новой сущности, редирект

    public function adding(){
        $this->validate();
        if(true/*$this->validateForms()*/) {
            $id_team = DB::table('teams')->insertGetId([
                'name' => $this->name,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
            foreach($this->selected_users_id as $users_id) {
                DB::table('players')->insert([
                    'id_team' => $id_team,
                    'id_user' => $users_id,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
            }
            $this->modalFormVisible = false;
            redirect("/teams", [\App\Http\Controllers\Teams\TeamsController::class, 'index']);
        }
        else {
            $this->errorOutput .= 'Сделайте окончательный выбор игроков и роботов!';
        }
    }
    // метод изменения сущности, редирект

    public function modification(){
        $this->validate();
        if(true/*$this->validateForms()*/) {
            Team::where('id', $this->current_team)->update([
                'name' => $this->name,
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
            Player::where("id_team", $this->current_team)->delete();
            foreach ($this->selected_users_id as $users_id){
                DB::table('players')->insert([
                    'id_team' => $this->current_team,
                    'id_user' => $users_id,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
            }

            $this->modalFormVisible = false;
            redirect("/teams", [\App\Http\Controllers\Teams\TeamsController::class, 'index']);
        }
        else {
            $this->errorOutput .= 'Сделайте окончательный выбор игроков и роботов!';
        }
    }

    public function render()
    {
        return view('livewire.add-team');
    }

/*    private function validateForms(): bool
    {
        if($this->counterUserForms == 0)
            return false;

        for ($i = 0; $i < $this->counterUserForms; $i++) {
            if ($this->{"idSelectedRobot" . $i} == 0 || $this->{"idUserForm" . $i} == 0) {
                $this->errorOutput .= $this->{"idSelectedRobot" . $i}." ".$this->{"idUserForm" . $i};
                return false;
            }
        }
        return true;
    }*/


}
