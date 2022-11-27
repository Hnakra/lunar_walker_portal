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
    public $name, $selected_users_id = [], $selected_trainer = 0;
    //    Переменные отображения
    public $users = [], $MAX_SELECTED_USERS = 5;
    // Переменная состояния, редактируется ли сущность (а также id сущности)
    public $current_team = 0;
    // Переменные отображения

    public $errorOutput;
    // Настройка правил валидации для формы
    protected $rules = [
        'name' => 'required|min:2',
        'selected_users_id.*' => 'distinct|not_in:0',

    ];
    protected $messages = [
        'selected_users_id.*.distinct' => 'Нужно выбрать разных игроков',
        'selected_users_id.*.not_in' => 'Нужно выбрать игроков!',
    ];
    // метод вызова модельного окна для создания сущности

    public function createShowModal(){
        $this->users = $this->getUsers();
        $this->modalFormVisible = true;
    }
    // метод вызова модельного окна для изменения сущности
    public function editShowModal(){
        $team = Team::where("id", $this->current_team)->get()->first();
        $this->selected_users_id = Player::where("id_team", $team->id)->pluck('id_user')->toArray();
        $this->name = $team->name;
        $this->selected_trainer = $team->id_trainer;
        $this->users = $this->getUsers();
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
        $id_team = DB::table('teams')->insertGetId([
            'name' => $this->name,
            'id_trainer' => $this->selected_trainer,
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
    // метод изменения сущности, редирект

    public function modification(){
        $this->validate();

        Team::where('id', $this->current_team)->update([
            'name' => $this->name,
            'id_trainer' => $this->selected_trainer,
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

    public function render()
    {
        return view('livewire.add-team');
    }
    // получить список пользователей без тренеров (но добавить текущего тренера)
    private function getUsers()
    {
        $users = User::where('id_role', 3)->get();
        foreach($users as $key => $user){
            if (Team::where('id_trainer', $user->id)->get()->isNotEmpty() ){
                unset($users[$key]);
            }
        }
        if($this->current_team && $id_trainer = Team::find($this->current_team)->id_trainer){
            $users->add(User::find($id_trainer));
        }
        return $users;
    }
}
