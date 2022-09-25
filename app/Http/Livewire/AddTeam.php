<?php

namespace App\Http\Livewire;

use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddTeam extends Component
{
    public $current_team = 0;
    public $modalFormVisible = false;
    public $name, $id_place, $userForm="";
    public $idUserForm0 = 0, $idUserForm1 = 0, $idUserForm2 = 0, $idUserForm3 = 0, $idUserForm4 = 0;
    public $idSelectedRobot0 = 0, $idSelectedRobot1 = 0, $idSelectedRobot2 = 0, $idSelectedRobot3 = 0, $idSelectedRobot4 = 0;
    public $counterUserForms = 0, $maxNumForms = 5;
    public $errorOutput;

    protected $rules = [
       'name' => 'required|min:2',
       // 'name' => 'required|null'
        ];

    public function editShowModal(){
        $team = Team::where("id", $this->current_team)->get()->first();
        $players = Player::where("id_team", $team->id)->get();
        $this->name = $team->name;
        $this->counterUserForms = count($players);
        for ($i = 0; $i < $this->counterUserForms; $i++) {
            $this->{"idUserForm".$i} = $players[$i]->id_user;
            $this->{"idSelectedRobot".$i} = $players[$i]->id_robot;
        }
        $this->userForm = $this->getUserForm();
        $this->modalFormVisible = true;
    }
    public function modification(){
        $this->validate();
        if($this->validateForms()) {
            Team::where('id', $this->current_team)->update([
                'name' => $this->name,
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
            Player::where("id_team", $this->current_team)->delete();
            for ($i = 0; $i < $this->counterUserForms; $i++) {
                DB::table('players')->insert([
                    'id_team' => $this->current_team,
                    'id_user' => $this->{"idUserForm" . $i},
                    'id_robot' => $this->{"idSelectedRobot" . $i},
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
            }
            $this->modalFormVisible = false;
            redirect("/places/$this->id_place/teams", [\App\Http\Controllers\TeamsController::class, 'index']);
        }
        else {
            $this->errorOutput .= 'Сделайте окончательный выбор игроков и роботов!';
        }
    }



    public function createUserForm(){
        $this->counterUserForms++;
        $this->userForm = $this->getUserForm();
    }
    public function removeUserForm(){
        $this->counterUserForms--;
        ${"idUserForm".$this->counterUserForms} = 0; ${"idSelectedRobot".$this->counterUserForms} = 0;

        $this->userForm = $this->getUserForm();
    }

    public function refreshUserForm(){
        $this->userForm = $this->getUserForm();
    }
    private function getUserForm(): string
    {
        $result = "";
        for ($i=0; $i < $this->counterUserForms; $i++){
            $result .= '<select wire:model="idUserForm'.$i.'" wire:click="refreshUserForm">'.$this->getListUsers().'</select>';
            $currentIdUserForm = $this->{"idUserForm".$i};
            if ($currentIdUserForm != 0) {
                $roboList = Robot::where('id_master', $currentIdUserForm)->where('is_working', 1)->get();
                if (count($roboList) > 0) {
                    $robotsOptions = "";
                    foreach($roboList as $robot){

                        $robotsOptions .= '<option value="'.$robot->id.'">'.$robot->name.'</option>';
                    }
                    $result .= '<select wire:model="idSelectedRobot'.$i.'">'.$robotsOptions.'</select>';
                    $this->{"idSelectedRobot".$i} = $roboList[0]->id;
                } else {
                    $result .= "У этого пользователя нет роботов!";
                }
            }
            $result .= "<br>";
        }

        return $result;
    }
    private function getListUsers(): string
    {
        $result = [];
        $listUsers = User::all();
        foreach($listUsers as $user){
            $elem = '<option value="'.$user->id.'" >'.$user->name.'</option>';
            array_push($result, $elem);
        }
        array_unshift(   $result, '<option selected>Выберите игрока</option>');
        return implode($result);
    }
    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function adding(){
        $this->validate();
        if($this->validateForms()) {
            $id_team = DB::table('teams')->insertGetId([
                'name' => $this->name,
                'id_place' => $this->id_place,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
            for ($i = 0; $i < $this->counterUserForms; $i++) {
                DB::table('players')->insert([
                    'id_team' => $id_team,
                    'id_user' => $this->{"idUserForm" . $i},
                    'id_robot' => $this->{"idSelectedRobot" . $i},
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
            }
            $this->modalFormVisible = false;
            redirect("/places/$this->id_place/teams", [\App\Http\Controllers\TeamsController::class, 'index']);
        }
        else {
            $this->errorOutput .= 'Сделайте окончательный выбор игроков и роботов!';
        }
    }
    public function render()
    {
        return view('livewire.add-team');
    }

    private function validateForms(): bool
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
    }
/*    public function remove(){
        $modalFormVisible = false;
    }*/

}
