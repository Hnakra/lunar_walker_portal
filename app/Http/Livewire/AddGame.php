<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class AddGame, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 */
class AddGame extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменные формы
    public $id_tournament, $id_team_1, $id_team_2, $date, $time;
    // Переменные отображения
    public $last_datetime, $teams = [];
    // Переменная состояния, редактируется ли сущность (а также id сущности)
    public $current_game = 0;
    // Настройка правил валидации для формы
    protected $rules = [
        'date' => 'required|date_format:Y-m-d',
        'time' => 'required|date_format:H:i',
        'id_team_1' => 'required|not_in:0',
        'id_team_2' => 'required|not_in:0|different:id_team_1'
    ];
    // Настройка правил сообщений для формы
    protected $messages = [
        'date.required' => 'Введите дату', 'date.date_format' => "Введите дату в формате Y-m-d",
        'time.required' => 'Введите время', 'time.date_format' => "Введите время в формате Часы:Минуты",
        'id_team_1.required' => 'Выберите команду 1', 'id_team_1.not_in' => 'Выберите команду 1',
        'id_team_2.required' => 'Выберите команду 2', 'id_team_2.not_in' => 'Выберите команду 2',
        'id_team_2.different' => 'Одна и та же команда не может играть против себя!'
    ];
    // метод вызова модельного окна для создания сущности

    public function createShowModal(){
        // возьмем команды данного турнира.
        // для этого, сделаем сложный запрос, состоящий из where и leftJoin
        // с помощью where находим те команды в teams_in_tournaments, у которых тот id турнира, который нам нужен
        // с помощью leftJoin присоеденим к получившейся выборке наши команды из teams, "скрепив" их id
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)->leftJoin('teams_in_tournaments','teams_in_tournaments.id_team', '=','teams.id')->get();
        // для отображения даты и времени раздельно, разъеденим их , так как сейчас они в формате "дд.мм.гггг H:M"
        list($this->date, $this->time) = explode(" ", $this->last_datetime);
        $this->modalFormVisible = true;
    }
    // метод сохранения новой сущности, редирект
    public function submitShowModal(){
        // из за неопознанного бага обновления переменной, обновляем ее содержимое
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)->leftJoin('teams_in_tournaments','teams_in_tournaments.id_team', '=','teams.id')->get();
        // валидация всех значений, указанных в $rules
        $this->validate();
        // добавляем новую запись в games
        // открываем базу данных и последовательно заполняем каждый элемент таблицы, кроме id
        DB::table('games')->insert([
            'id_tournament' => $this->id_tournament,
            'id_team_1' => $this->id_team_1,
            'id_team_2' => $this->id_team_2,
            'count_team_1' => 0,
            'count_team_2' => 0,
            'date_time' => $this->date." ".$this->time,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        $this->modalFormVisible = false;
        // редирект на страницу, чтобы перерисовать ее с новыми изменениями
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    // метод вызова модельного окна для изменения сущности

    public function editShowModal(){
        $game = Game::find($this->current_game);
        $this->id_tournament = $game->id_tournament;
        $this->id_team_1 = $game->id_team_1;
        $this->id_team_2 = $game->id_team_2;
        $this->date = $game->date;
        $this->time = $game->time;
        $this->last_datetime = $game->last_datetime;
        $this->teams =Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)->leftJoin('teams_in_tournaments','teams_in_tournaments.id_team', '=','teams.id')->get();;
        $this->modalFormVisible = true;
        list($this->date, $this->time) = explode(" ", $game->date_time);
    }
    // метод изменения сущности, редирект
    public function modifyShowModal(){
        // из за неопознанного бага обновления переменной, обновляем ее содержимое
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)->leftJoin('teams_in_tournaments','teams_in_tournaments.id_team', '=','teams.id')->get();

        // валидация всех значений, указанных в $rules
        $this->validate();
        DB::table('games')->where('id', $this->current_game)->update([
            'id_tournament' => $this->id_tournament,
            'id_team_1' => $this->id_team_1,
            'id_team_2' => $this->id_team_2,
            'date_time' => $this->date." ".$this->time,
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        redirect( "/game/".$this->current_game, [\App\Http\Controllers\Games\Game\GameController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.add-game');
    }
}
