<?php
namespace App\Traits\TournamentsTable;
use App;
use App\Models\Game;
use App\Models\Team;
use App\Models\TeamsInTournament;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

trait AddTournamentsTable
{
    //private int $interval, $max_seconds_match;
    // todo refactor
    private function makeGames($selectedTable, $teams)
    {
        switch ($selectedTable) {
            case 'all_vs_all':
                $this->all_vs_all_generate($teams);
                break;
        }
    }

    private function all_vs_all_generate($teams)
    {
        $teams = $teams->values();
        $games = $this::get_all_vs_all_games($teams);
        shuffle($games);
        foreach ($games as $k => $game){

            // $group = $this->generateNumberOfGroup($k);
            $tournament = Tournament::find($this->id_tournament);
            $tournament->isGenerated = true;
            $tournament->save();

            Game::create([
                'id_tournament' => $this->id_tournament,
                'id_team_1' => $game[0],
                'id_team_2' => $game[1],
                'count_team_1' => 0,
                'count_team_2' => 0,
                'date_time' => date("Y-m-d H:i:s", strtotime($tournament->date_time)+$this->interval*60*$k),
                'max_seconds_match' => $this->max_seconds_match,
                'datetime_state' => date("Y-m-d H:i:s", 0)
            ]);
        }

    }

    private static function get_all_vs_all_games($teams){
        $games = [];
        for ($i = 0; $i < $teams->count(); $i++) {
            for ($j = $i+1; $j < $teams->count(); $j++) {
                array_push($games, [$teams->get($i)->id_team, $teams->get($j)->id_team]);
            }
        }
        return $games;
    }
    private static function checkAllVSAll(Tournament $tournament): bool
    {
        for ($i = 1; $i <= $tournament->numGroups(); $i++) {
            $teamsInGroup = $tournament->getTeamsByGroupId($i);
            $gamesInGroup = $tournament->getGamesByGroupId($i);
            $gamesReferences = self::get_all_vs_all_games($teamsInGroup);
            if (count($gamesReferences) !== count($gamesInGroup)) {
                return false;
            }
        }
        return true;
    }
    private static function getGroupData($tournament): array
    {
        $result = [];
        for ($i = 1; $i <= $tournament->numGroups(); $i++) {
            $result[$i] = [];
            $teamsInGroup = $tournament->getTeamsByGroupId($i);
            $gamesInGroup = $tournament->getGamesByGroupId($i);

            $teamGroup = TeamsInTournament::getGroupNameByIdGroup($teamsInGroup->first()->group);
            $result[$i]['head'] = [];
            $result[$i]['head'][] = $teamGroup;
            $result[$i]['head'][] = __('Команда');

            $result[$i]['headDescription'] = [];
            $result[$i]['headDescription'][] = __('Группа')." $teamGroup";
            $result[$i]['headDescription'][] = "";

            foreach ($teamsInGroup as $j => $team) {
                $result[$i]['head'][] = $j + 1;
                $result[$i]['headDescription'][] = __('Команда')." $team->name";
                $result[$i][$j] = [];
                $result[$i][$j]['number'] = $j + 1;
                $result[$i][$j]['teamName'] = $team->name;
                $result[$i][$j]['games'] = [];
                $result[$i][$j]['gameDescription'] = [];
                $result[$i][$j]['teamId'] = $team->id;
                $count_win = 0;
                $count_lose = 0;
                $num_win = 0;
                $num_lose = 0;
                $num_draw = 0;
                for ($z = 1; $z <= $teamsInGroup->count(); $z++) {
                    if ($j + 1 === $z) {
                        $result[$i][$j]['games'][$z] = 'X';
                        $result[$i][$j]['gameDescription'][$z] = 'X';
                    } else {
                        if ($j + 1 < $z) {
                            // Верхнеуголь
                            $game = $gamesInGroup->where('id_team_1', $teamsInGroup[$j]->id)
                                ->where('id_team_2', $teamsInGroup[$z - 1]->id)
                                ->first();

                            if ($game->id_state === 1) {
                                $result[$i][$j]['games'][$z] = '-';
                                $result[$i][$j]['gameDescription'][$z] = __('Игра не началась');
                            } else {
                                $result[$i][$j]['games'][$z] = "$game->count_team_1:$game->count_team_2";
                                $count_win += $game->count_team_1;
                                $count_lose += $game->count_team_2;

                                if ($game->count_team_1 === $game->count_team_2) {
                                    $result[$i][$j]['gameDescription'][$z] = __('Ничья');
                                    $num_draw++;
                                } else {
                                    if ($game->count_team_1 > $game->count_team_2) {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name ". __('выиграла');
                                        $num_win++;
                                    } else {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name ". __('проиграла');
                                        $num_lose++;
                                    }
                                }

                            }
                        } else {
                            // Нижеуголь
                            $game = $gamesInGroup->where('id_team_2', $teamsInGroup[$j]->id)
                                ->where('id_team_1', $teamsInGroup[$z - 1]->id)
                                ->first();

                            if ($game->id_state === 1) {
                                $result[$i][$j]['games'][$z] = '-';
                                $result[$i][$j]['gameDescription'][$z] = __('Игра не началась');
                            } else {
                                $result[$i][$j]['games'][$z] = "$game->count_team_2:$game->count_team_1";
                                $count_win += $game->count_team_2;
                                $count_lose += $game->count_team_1;

                                if ($game->count_team_2 === $game->count_team_1) {
                                    $result[$i][$j]['gameDescription'][$z] = __('Ничья');
                                    $num_draw++;
                                } else {
                                    if ($game->count_team_2 > $game->count_team_1) {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name ". __('выиграла');
                                        $num_win++;
                                    } else {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name ". __('проиграла');
                                        $num_lose++;
                                    }
                                }
                            }
                        }
                    }

                }

                $result[$i][$j]['points'] = $num_win * 2 + $num_draw;
                $result[$i][$j]['pointsDescription'] = __('Побед').": $num_win (" . ($num_win * 2) . " ".__('очк').")\n".
                    __('Ничей').": $num_draw ($num_draw ".__('очк').")\n".
                    __('Поражений').": $num_lose (0 ".__('очк').")";
                $result[$i][$j]['different'] = $count_win - $count_lose;
                $result[$i][$j]['differentDescription'] = __('Суммарно забитых голов').": $count_win\n".
                    __('Суммарно пропущенных голов').": $count_lose";
            }
            $result[$i]['head'][] = App::isLocale('ru') ? "О" : 'P'; //points
            $result[$i]['headDescription'][] = __('Очков добыто')."\n".
                __('Победа')." - 2 ".__('очка')."\n".
                __('Ничья')." - 1 ".__('очко')."\n".
                __('Поражение').' - 0 '.__('очков');
            $result[$i]['head'][] = App::isLocale('ru') ? "P": 'D'; // different
            $result[$i]['headDescription'][] = __('Разница между забитыми')." \n".__('и пропущенными голами');

            $teams = array_filter(array_map(fn($item) => isset($item['number']) ? $item : null, $result[$i]));
            uasort($teams, fn($a, $b) => $b['points'] <=> $a['points'] ?: $b['different'] <=> $a['different']);

            $places = array_fill(0, count($teams), 0);
            $pointer = 0;
            $current = reset($teams);
            foreach ($teams as $team) {
                if ($team['points'] === $current['points'] && $team['different'] === $current['different']) {
                    $places[$pointer]++;
                } else {
                    $places[++$pointer]++;
                }
                $current = $team;
            }
            $places = array_filter($places);

            $res = [];
            $sum = 1;
            for ($j = 0; $j < count($places); $j++) {
                $res = array_merge($res,
                    array_fill(0, $places[$j], implode('-', range($sum, $sum + $places[$j] - 1)))
                );
                $sum += $places[$j];
            }

            $k = 0;
            foreach ($teams as $j => $team) {
                $result[$i][$j]['place'] = $res[$k++];

                $numPlaces = explode('-', $result[$i][$j]['place']);
                $message = match (count($numPlaces)) {
                    1 => $result[$i][$j]['place'] . " ". __('место'),
                    2 => $team['teamName'] ." ". __('разделила с другой командой') ." ". implode(', ', $numPlaces) . " ". __('место'),
                    default => $team['teamName'] ." ". __('разделила с другими командами') ." ". implode(', ', $numPlaces) . " ". __('места'),
                };

                $result[$i][$j]['placeDescription'] = $message;
            }

            $result[$i]['head'][] = App::isLocale('ru')? "М" : 'T'; //top
            $result[$i]['headDescription'][] = __('Место в группе');
        }
        return $result;
    }
}
