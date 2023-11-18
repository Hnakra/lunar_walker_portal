<?php

namespace App\Http\Livewire\Forms;

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Monolog\Handler\RedisHandler;

class RoundTournamentPlayoffForm extends Component
{
    //    Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    public $id_tournament, $date, $time, $max_seconds_match = 300, $interval = 600;
    public $tournament, $games;


    public function createShowModal()
    {
        $this->tournament = Tournament::find($this->id_tournament);
        $this->games = $this->tournament->games->where('num_round', $this->tournament->num_round);
        $this->date = date('Y-m-d');
        $this->time = date('H:i');
        $this->modalFormVisible = true;
    }

    public function submitShowModal()
    {
        $rules = [
            'id_tournament' => function ($attribute, $value, $fail) {
                if (!$this->games->every(fn($game) => $game->count_team_1 !== $game->count_team_2)) {
                    $fail(__('В турнире есть команды, в которых результат игр - ничья!'));
                }
            }
        ];
        $this->validate($rules);

        if ($this->isFinalRoundPlayoff()) {
            $winnersIds = $this->games->map(fn($game) => $game->count_team_1 > $game->count_team_2 ? $game->id_team_1 : $game->id_team_2);
            $losersIds = $this->games->map(fn($game) => $game->count_team_1 > $game->count_team_2 ? $game->id_team_2 : $game->id_team_1);

            if ($this->tournament->currentRoundTeams() === 0) {
                $this->tournament->num_round = $this->tournament->num_round + 1;
            }
            $this->tournament->is_generated_playoff = true;

            $game1 = Game::create([
                'id_tournament' => $this->id_tournament,
                'id_team_1' => $winnersIds[0],
                'id_team_2' => $winnersIds[1],
                'count_team_1' => 0,
                'count_team_2' => 0,
                'date_time' => date("Y-m-d H:i:s", strtotime($this->date . ' ' . $this->time) + $this->interval * 0),
                'max_seconds_match' => $this->max_seconds_match,
                'datetime_state' => date("Y-m-d H:i:s", 0),
            ]);
            $game1->num_round = $this->tournament->num_round;
            $game1->save();

            $game2 = Game::create([
                'id_tournament' => $this->id_tournament,
                'id_team_1' => $losersIds[0],
                'id_team_2' => $losersIds[1],
                'count_team_1' => 0,
                'count_team_2' => 0,
                'date_time' => date("Y-m-d H:i:s", strtotime($this->date . ' ' . $this->time) + $this->interval * 1),
                'max_seconds_match' => $this->max_seconds_match,
                'datetime_state' => date("Y-m-d H:i:s", 0),
            ]);
            $game2->num_round = $this->tournament->num_round;
            $game2->save();

            $this->tournament->save();

        } else {
            $winnersIds = $this->games->map(fn($game) => $game->count_team_1 > $game->count_team_2 ? $game->id_team_1 : $game->id_team_2);

            if ($this->tournament->currentRoundTeams() === 0) {
                $this->tournament->num_round = $this->tournament->num_round + 1;
            }

            for ($i = 0; $i < $this->games->count(); $i += 2) {
                $game = Game::create([
                    'id_tournament' => $this->id_tournament,
                    'id_team_1' => $winnersIds[$i],
                    'id_team_2' => $winnersIds[$i + 1],
                    'count_team_1' => 0,
                    'count_team_2' => 0,
                    'date_time' => date("Y-m-d H:i:s", strtotime($this->date . ' ' . $this->time) + $this->interval * 60 * ($i / 2)),
                    'max_seconds_match' => $this->max_seconds_match,
                    'datetime_state' => date("Y-m-d H:i:s", 0),
                ]);
                $game->num_round = $this->tournament->num_round;
                $game->save();
            }
            $this->tournament->save();
        }
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }

    public function isCompletedPlayoff(): bool
    {
        return Tournament::find($this->id_tournament)->is_generated_playoff;
    }

    public function isFinalRoundPlayoff(): bool
    {
        return Tournament::find($this->id_tournament)->isFinalRoundPlayoff();
    }

    public function render()
    {
        return view('livewire.forms.round-tournament-playoff-form');
    }
}
