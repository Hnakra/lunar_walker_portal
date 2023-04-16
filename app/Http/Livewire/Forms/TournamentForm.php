<?php

namespace App\Http\Livewire\Forms;

use App\Mail\NotifyAboutCreateTournament;
use App\Models\Place;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * Class TournamentForm, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 */
class TournamentForm extends Component
{
//    Переменная открытия-закрытия формы
    public $modalFormVisible = false;
//    Переменные формы
    public $name, $id_place, $description="", $date, $time, $selected_teams_id = [];
    // Переменная для валидации, чтобы в выбранных командах не повторялись пользователи
    public $users = [];
//    Переменные отображения
    public $places = [], $teams = [];
    // Переменная состояния, редактируется ли сущность (а также id сущности)
    public $current_tournament = 0;

    // Настройка правил валидации для формы
    protected $rules = [
        'name' => 'required|min:3',
        "id_place" => "required",
        'date' => 'required|date_format:Y-m-d',
        'time' => 'required|date_format:H:i',
        'selected_teams_id.*' => 'distinct|not_in:0',
        'users.*' => 'distinct',
    ];
    // Настройка правил сообщений для формы
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
    // метод вызова модельного окна для создания сущности
    public function createShowModal(){
        $this->places = $this->getPlaces();
        $this->teams = Team::all();
        $this->modalFormVisible = true;
    }
    // метод сохранения новой сущности, редирект
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
                $data = [
                    "userName" => $player->name,
                    "teamName" => $player->teamName,
                    "tournamentName" => $this->name,
                    "placeName" => Place::find($this->id_place)->name,
                    "date_time" => "$this->date $this->time"

                ];
                Mail::to(User::find($player->id_user)->email)->queue(new NotifyAboutCreateTournament($data));
            }
        }
        $this->modalFormVisible = true;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);

    }
    // метод добавления команды на форму
    public function addTeam(){
        array_push($this->selected_teams_id, 0);
    }
    // метод удаление команды с формы
    public function removeTeam($index){
        unset($this->selected_teams_id[$index]);
    }
    // метод вызова модельного окна для изменения сущности

    public function editShowModal(){
        $tournament = Tournament::find($this->current_tournament);
        $this->name = $tournament->name;
        $this->id_place = $tournament->id_place;
        $this->description = $tournament->description;
        list($this->date, $this->time) = explode(" ", $tournament->date_time);
        $this->selected_teams_id = DB::table("teams_in_tournaments")
            ->where("id_tournament", $this->current_tournament)
            ->get()->pluck("id_team")->toArray();
        $this->places = $this->getPlaces();
        $this->teams = Team::all();
        $this->modalFormVisible = true;
    }
    // метод изменения сущности, редирект

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

        DB::table('teams_in_tournaments')->where('id_tournament', $this->current_tournament)->delete();
        foreach ($this->selected_teams_id as $team_id){
            DB::table('teams_in_tournaments')->insert([
                'id_tournament' => $this->current_tournament,
                'id_team' => $team_id,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]);
        }

        redirect( "/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.forms.tournament-form');
    }

    /**
     * Получение списка всех площадок, если ты админ, или получение лишь твоих площадок, если ты оргнаизатор
     * @return Place[]|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Place_C
     */
    private function getPlaces()
    {
        return Auth::user()->isAdmin() ?
            Place::all() :
            Place::where('id_organizator', Auth::user()->id)->get();
    }
}
