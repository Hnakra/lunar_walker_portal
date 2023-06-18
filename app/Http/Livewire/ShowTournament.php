<?php

namespace App\Http\Livewire;

use App\Models\TeamsInTournament;
use App\Models\Tournament;
use App\Traits\TournamentsTable\AddTournamentsTable;
use Livewire\Component;

class ShowTournament extends Component
{
    use AddTournamentsTable;

    /** @var bool Переменная открытия-закрытия формы */
    public $modalFormVisible = false;
    /** @var bool Переменная смены табличного отображения */
    public $alternativeVisible = false;
    /** @var bool Переменная, отображающая, нужно ли смена табличного отображения */
    public $isExistsAlternativeVisible;
    /** @var Tournament модель турнира */
    public $tournament;

    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function closeModal()
    {
        $this->modalFormVisible = false;
    }

    private function checkAllVSAll(Tournament $tournament)
    {
        for ($i = 1; $i <= $tournament->numGroups(); $i++) {
            $teamsInGroup = $tournament->getTeamsByGroupId($i);
            $gamesInGroup = $tournament->getGamesByGroupId($i);
            $gamesReferences = $this->get_all_vs_all_games($teamsInGroup);
            if (count($gamesReferences) !== count($gamesInGroup)) {
                return false;
            }
        }
        return true;
    }

    private function getGroupData(): array
    {
        $result = [];
        for ($i = 1; $i <= $this->tournament->numGroups(); $i++) {
            $result[$i] = [];
            $teamsInGroup = $this->tournament->getTeamsByGroupId($i);
            $gamesInGroup = $this->tournament->getGamesByGroupId($i);

            $teamGroup = TeamsInTournament::getGroupNameByIdGroup($teamsInGroup->first()->group);
            $result[$i]['head'] = [];
            $result[$i]['head'][] = $teamGroup;
            $result[$i]['head'][] = "Команда";

            $result[$i]['headDescription'] = [];
            $result[$i]['headDescription'][] = "Группа $teamGroup";
            $result[$i]['headDescription'][] = "";

            foreach ($teamsInGroup as $j => $team) {
                $result[$i]['head'][] = $j + 1;
                $result[$i]['headDescription'][] = "Команда $team->name";
                $result[$i][$j] = [];
                $result[$i][$j]['number'] = $j + 1;
                $result[$i][$j]['teamName'] = $team->name;
                $result[$i][$j]['games'] = [];
                $result[$i][$j]['gameDescription'] = [];
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
                                $result[$i][$j]['gameDescription'][$z] = 'Игра не началась';
                            } else {
                                $result[$i][$j]['games'][$z] = "$game->count_team_1:$game->count_team_2";
                                $count_win += $game->count_team_1;
                                $count_lose += $game->count_team_2;

                                if ($game->count_team_1 === $game->count_team_2) {
                                    $result[$i][$j]['gameDescription'][$z] = "Ничья";
                                    $num_draw++;
                                } else {
                                    if ($game->count_team_1 > $game->count_team_2) {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name выиграла";
                                        $num_win++;
                                    } else {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name проиграла";
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
                                $result[$i][$j]['gameDescription'][$z] = 'Идет не началась';
                            } else {
                                $result[$i][$j]['games'][$z] = "$game->count_team_2:$game->count_team_1";
                                $count_win += $game->count_team_2;
                                $count_lose += $game->count_team_1;

                                if ($game->count_team_2 === $game->count_team_1) {
                                    $result[$i][$j]['gameDescription'][$z] = "Ничья";
                                    $num_draw++;
                                } else {
                                    if ($game->count_team_2 > $game->count_team_1) {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name выиграла";
                                        $num_win++;
                                    } else {
                                        $result[$i][$j]['gameDescription'][$z] = "$team->name проиграла";
                                        $num_lose++;
                                    }
                                }
                            }
                        }
                    }

                }

                $result[$i][$j]['points'] = $num_win * 2 + $num_draw;
                $result[$i][$j]['pointsDescription'] = "Побед: $num_win (" . ($num_win * 2) . " очк)\nНичей: $num_draw ($num_draw очк)\nПоражений: $num_lose (0 очк)";
                $result[$i][$j]['different'] = $count_win - $count_lose;
                $result[$i][$j]['differentDescription'] = "Суммарно забитых голов: $count_win\nСуммарно пропущенных голов: $count_lose";
            }
            $result[$i]['head'][] = "О";
            $result[$i]['headDescription'][] = "Очков добыто\nПобеда - 2 очка\nНичья - 1 очко\nПоражение - 0 очков";
            $result[$i]['head'][] = "P";
            $result[$i]['headDescription'][] = "Разница между забитыми \nи пропущенными голами";

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
                    1 => $result[$i][$j]['place'] . " место",
                    2 => $team['teamName'] . " разделила с другой командой " . implode(', ', $numPlaces) . " место",
                    default => $team['teamName'] . " разделила с другими командами " . implode(', ', $numPlaces) . " места",
                };

                $result[$i][$j]['placeDescription'] = $message;
            }

            $result[$i]['head'][] = "М";
            $result[$i]['headDescription'][] = "Место в группе";
        }

        return $result;
    }

    public function render()
    {
        $this->isExistsAlternativeVisible = $this->checkAllVSAll($this->tournament);
        return $this->alternativeVisible ?
            view('livewire.show-tournament-alternative', ["groups" => $this->getGroupData()]) :
            view('livewire.show-tournament');
    }


}
