<?php

namespace App\Http\Livewire;

use App\Mail\NotifyAboutCreateTournament;
use App\Models\Place;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\User;
use App\Traits\TournamentsTable\AddTournamentsTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GeneratePlayoff extends Component
{
    use AddTournamentsTable;

    public $modalFormVisible = false;
    public $id_tournament;
    public $tournament;
    public $name, $description, $date, $time, $teams; /*, $selected_teams_id = []*/

    protected $rules = [
        'name' => 'required|min:3',
        'date' => 'required|date_format:Y-m-d',
        'time' => 'required|date_format:H:i',

    ];
    // Настройка правил сообщений для формы
    protected function getMessages()
    {
        return [
            'name.required' => __("Поле не должно быть пустым!"),
            "name.min" => __("Название должно содержать не менее 3 букв"),
            'date.required' => __('Введите дату'), 'date.date_format' => __("Введите дату в формате Y-m-d"),
            'time.required' => __('Введите время'), 'time.date_format' => __("Введите время в формате hh:mm"),
        ];
    }

    public function createShowModal()
    {
        $this->tournament = Tournament::find($this->id_tournament);
        $this->name = $this->tournament->name . " Playoff";
        $this->description = "Playoff";
        $this->date = explode(' ', $this->tournament->date_time)[0];
        $this->teams = [];
        $tournamentResult = self::getGroupData($this->tournament);
        foreach ($tournamentResult as $group) {
            foreach ($group as $key => $value) {
                if ($key !== 'head' && $key !== 'headDescription') {
                    array_push($this->teams, [
                        'id' => $value['teamId'],
                        'place' => $value['place'],
                        'team' => $value['teamName'] . " (" . $value['place'] . " ".__('Место').", ".__('Кол-во очков').": " . $value['points'] . " , ".__('Группа').": " . $group['head'][0] . ")",
                        'isChecked' => str_contains('1', $value['place'])
                    ]);
                }
            }
        }
        usort($this->teams, fn($a, $b) => $a['place'] <=> $b['place']);

        $this->modalFormVisible = true;
    }

    public function submitShowModal()
    {
        $this->rules = array_merge($this->rules, [
            'teams' => function ($attribute, $value, $fail) {
                $number = 0;
                foreach ($value as $v) {
                    $number += $v['isChecked'] ? 1 : 0;
                }
                if (!$this->_isPowerOfTwo($number)) {
                    $fail(__("Кол-во выбранных команд - не степень двойки!"));
                }
            }
        ]);

        $this->validate($this->rules, $this->getMessages());

        $id_tournament = DB::table('tournaments')->insertGetId([
            'name' => $this->name,
            'description' => $this->description,
            'date_time' => "$this->date $this->time",
            'id_place' => $this->tournament->id_place,
            'id_creator' => Auth::user()->id,
            'isGenerated' => true,
            'is_playoff' => true,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        foreach ($this->teams as $value) {
            if ($value['isChecked']) {
                DB::table('teams_in_tournaments')->insert([
                    'id_tournament' => $id_tournament,
                    'id_team' => $value['id'],
                    'alias' => $value['team'],
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                ]);
            }

        }

        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.generate-playoff');
    }

    private function _isPowerOfTwo($value)
    {
        if ($value < 2) {
            return false;
        }
        $initValue = 1;
        while ($initValue < $value)
            $initValue *= 2;
        return $initValue == $value;
    }

    public function update_checkbox($teamKey)
    {
        $this->teams[$teamKey]['isChecked'] = !$this->teams[$teamKey]['isChecked'];
    }
}
