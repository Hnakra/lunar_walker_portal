<?php

namespace App\Http\Livewire\Forms;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamsInTournament;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class GameForm, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 * @property Illuminate\Database\Eloquent\Collection $team
 */
class GameForm extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменные формы
    public $id_tournament, $id_team_1, $id_team_2, $date, $time, $max_seconds_match = 300;
    // Переменные отображения
    public $last_datetime, $is_grouped;
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
    protected function getMessages()
    {
        return [
            'date.required' => __('Введите дату'), 'date.date_format' => __('Введите дату в формате Y-m-d'),
            'time.required' => __('Введите время'), 'time.date_format' => __('Введите время в формате Часы:Минуты'),
            'id_team_1.required' => __('Выберите команду 1'), 'id_team_1.not_in' => __('Выберите команду 1'),
            'id_team_2.required' => __('Выберите команду 2'), 'id_team_2.not_in' => __('Выберите команду 2'),
            'id_team_2.different' => __('Одна и та же команда не может играть против себя!')
        ];
    }

    public function getTeamsProperty()
    {
        return Team::where('teams_in_tournaments.id_tournament', $this->id_tournament)
            ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
            ->get();
    }

    // метод вызова модельного окна для создания сущности
    public function createShowModal()
    {
        // для отображения даты и времени раздельно, разъеденим их , так как сейчас они в формате "дд.мм.гггг H:M"
        list($this->date, $this->time) = explode(" ", $this->last_datetime);
        $this->modalFormVisible = true;
    }

    // метод сохранения новой сущности, редирект
    public function submitShowModal()
    {
        // валидация всех значений, указанных в $rules
        $this->validate($this->rules, $this->getMessages());

        // если турнир - плейофф и у него всего 1 игра (финальная), закрыть этот плейофф
        $tournament = Tournament::find($this->id_tournament);
        if ($tournament->is_playoff && $tournament->currentRoundTeamsCount() === 2) {

            $tournament->is_generated_playoff = true;
            $tournament->save();
        }

        // добавляем новую запись в games
        // открываем базу данных и последовательно заполняем каждый элемент таблицы, кроме id
        $idGame = DB::table('games')->insertGetId([
            'id_tournament' => $this->id_tournament,
            'id_team_1' => $this->id_team_1,
            'id_team_2' => $this->id_team_2,
            'count_team_1' => 0,
            'count_team_2' => 0,
            'date_time' => $this->date . " " . $this->time,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'id_state' => 1,
            'datetime_state' => date("Y-m-d H:i:s", strtotime('now')),
            'max_seconds_match' => $this->max_seconds_match
        ]);

        $this->modalFormVisible = false;
        // редирект на страницу, чтобы перерисовать ее с новыми изменениями
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }

    // метод вызова модельного окна для изменения сущности

    public function editShowModal()
    {
        $game = Game::find($this->current_game);
        $this->id_tournament = $game->id_tournament;
        $this->id_team_1 = $game->id_team_1;
        $this->id_team_2 = $game->id_team_2;
        $this->date = $game->date;
        $this->time = $game->time;
        $this->max_seconds_match = $game->max_seconds_match;
        $this->last_datetime = $game->last_datetime;
        $this->modalFormVisible = true;
        list($this->date, $this->time) = explode(" ", $game->date_time);
    }

    // метод изменения сущности, редирект
    public function modifyShowModal()
    {
        // валидация всех значений, указанных в $rules
        $this->validate($this->rules, $this->getMessages());
        DB::table('games')->where('id', $this->current_game)->update([
            'id_tournament' => $this->id_tournament,
            'id_team_1' => $this->id_team_1,
            'id_team_2' => $this->id_team_2,
            'date_time' => $this->date . " " . $this->time,
            'max_seconds_match' => $this->max_seconds_match,
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        redirect("/game/" . $this->current_game, [\App\Http\Controllers\Games\Game\GameController::class, 'index']);
    }

    public function render()
    {
        $this->is_grouped = Tournament::find($this->id_tournament)->isGrouped();
        return view('livewire.forms.game-form');
    }
}
