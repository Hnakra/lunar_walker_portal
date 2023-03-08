<?php
namespace App\Traits\TournamentsTable;
use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

trait AddTournamentsTable
{

    private Collection $teams;
    //private int $interval, $max_seconds_match;

    private function makeGames($selectedTable, $id_tournament)
    {
        $this->teams = Team::where('teams_in_tournaments.id_tournament', $id_tournament)
            ->leftJoin('teams_in_tournaments', 'teams_in_tournaments.id_team', '=', 'teams.id')
            ->get();
        switch ($selectedTable) {
            case 'all_vs_all':
                $this->all_vs_all_generate();
                break;
        }
    }

    /**
     * @param $numGroups - кол-во групп (кол-во полей)
     * @param $k - порядковый номер игры
     * @return int
     * код для нахождения порядка игры в случаях, если на площадке больше 1го поля
     * Пример в случае, если площадки 3, а игр 4:
     *   Игра1 - играет первый на площадке 1
     *   Игра2 - играет второй на площадке 2
     *   Игра3 - играет третий на площадке 3
     *   Игра4 - играет первый на площадке 1
     *
     * Принцип вычисления:
     *   Находим $m - остаток от деления $k на $numGroups
     *   После чего вычисляем разницу между $k и $m.
     *   Получившееся число кратно $numGroups, потому на него надо и поделить
     */

    private function generateNumberOfGroup($k, $numGroups = 1): int
    {
        $m = $k%$numGroups;
        return ($k-$m)/$numGroups+1;
    }

    private function all_vs_all_generate()
    {
        $games = [];
        for ($i = 0; $i < $this->teams->count(); $i++) {
            for ($j = $i+1; $j < $this->teams->count(); $j++) {
                array_push($games, [$this->teams->get($i)->id_team, $this->teams->get($j)->id_team]);
            }
        }
        shuffle($games);
        foreach ($games as $k => $game){

            $group = 1;
            // $group = $this->generateNumberOfGroup($k);
            $tournament_date = Tournament::find($this->id_tournament)->date_time;
            Game::create([
                'id_tournament' => $this->id_tournament,
                'id_team_1' => $game[0],
                'id_team_2' => $game[1],
                'count_team_1' => 0,
                'count_team_2' => 0,
                'date_time' => date("Y-m-d H:i:s", strtotime($tournament_date)+$this->interval*60*$k),
                'max_seconds_match' => $this->max_seconds_match,
                'datetime_state' => date("Y-m-d H:i:s", 0)
            ]);
        }

        Log::info(strtotime('now'));
    }
}
