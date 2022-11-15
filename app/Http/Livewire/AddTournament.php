<?php

namespace App\Http\Livewire;

use App\Mail\NotifyAboutCreateTournament;
use App\Models\Place;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use App\Rules\UsersInTournamentUnique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddTournament extends Component
{
//    Переменная открытия-закрытия формы
    public $modalFormVisible = false;
//    Переменные формы
    public $name, $id_place, $description="", $date, $time, $selected_teams_id = [];
    // Переменная для валидации, чтобы в выбранных командах не повторялись пользователи
    public $users = [];
//    Переменные отображения
    public $places = [], $teams = [];

    public $current_tournament = 0;

    // Настройка правил валидации для нашей формы
    protected $rules = [
        'name' => 'required|min:3',
        "id_place" => "required",
        'date' => 'required|date_format:Y-m-d',
        'time' => 'required|date_format:H:i',
        'selected_teams_id.*' => 'distinct|not_in:0',
        'users.*' => 'distinct',
    ];
    // Настройка правил сообщений для нашей формы
    protected $messages = [
        'name.required' => "Поле не должно быть пустым!",
        "name.min" => "Название должно содержать не менее 3 букв",
        "id_place.required" => "Поле не должно быть пустым!",
        'date.required' => 'Введите дату', 'date.date_format' => "Введите дату в формате Y-m-d",
        'time.required' => 'Введите время', 'time.date_format' => "Введите время в формате hh:mm",
        'selected_teams_id.*.distinct' => 'Нужно выбрать разные команды',
        'selected_teams_id.*.not_in' => 'Нужно выбрать команды',
        'users.*.distinct' => 'Пользователи в командах не должны повторяться!',
    ];
    public function createShowModal(){
        $this->places = Place::all();
        $this->teams = Team::all();
        $this->modalFormVisible = true;
    }
    public function submitShowModal(){
        $this->users = [];
        foreach($this->selected_teams_id as $team_id){
            $users = Player::where("id_team", $team_id)->get()->pluck('id_user')->toArray();
            $this->users = array_merge($this->users, $users);
        }
        // валидация всех значений, указанных в $rules
        $this->validate();
        $id_tournament = DB::table('tournaments')->insertGetId([
            'name'=> $this->name,
            "id_place" => $this->id_place,
            'description' => $this->description,
            'date_time' => "$this->date $this->time",
            'id_place' => $this->id_place,
            'id_creator' => Auth::user()->id,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        foreach ($this->selected_teams_id as $team_id){
            DB::table('teams_in_tournaments')->insert([
                'id_tournament' => $id_tournament,
                'id_team' => $team_id,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
            $players = Player::select(DB::raw("players.*, users.name, teams.name as teamName"))->where('id_team', $team_id)
                ->leftJoin('users', 'players.id_user', '=', 'users.id')
                ->leftJoin('teams', 'players.id_team', '=', 'teams.id')
                ->get();
            foreach ($players as $player) {
                DB::table('submit_tournaments')->insert([
                    'id_tournament' => $id_tournament,
                    'id_team' => $team_id,
                    'id_user' => $player->id_user,
                    'is_submit' => false,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
                $data = [
                    "userName" => $player->name,
                    "teamName" => $player->teamName,
                    "tournamentName" => $this->name,
                    "placeName" => Place::find($this->id_place)->name,
                    "date_time" => "$this->date $this->time"

                ];
                // Позже, ВКЛЮЧИТЬ ОБРАТНО
                // Mail::to(User::find($player->id_user)->email)->send(new NotifyAboutCreateTournament($data));
            }
        }
        $this->modalFormVisible = true;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);

    }
    public function addTeam(){
        array_push($this->selected_teams_id, 0);
    }
    public function removeTeam($index){
        unset($this->selected_teams_id[$index]);
    }

    public function editShowModal(){
        $tournament = Tournament::find($this->current_tournament);
        $this->name = $tournament->name;
        $this->id_place = $tournament->id_place;
        $this->description = $tournament->description;
        list($this->date, $this->time) = explode(" ", $tournament->date_time);
        $this->selected_teams_id = DB::table("teams_in_tournaments")
            ->where("id_tournament", $this->current_tournament)
            ->get()->pluck("id_team")->toArray();
        $this->places = Place::all();
        $this->teams = Team::all();
        $this->modalFormVisible = true;
    }
    public function modifyShowModal(){
        $this->validate();
        DB::table('tournaments')->where("id", $this->current_tournament)
            -> update([
                'id_place' => $this->id_place,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                'name' => $this->name,
                'description' => $this->description,
            ]);
        redirect( "/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.add-tournament');
    }
}
