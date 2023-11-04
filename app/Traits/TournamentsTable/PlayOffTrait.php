<?php

namespace App\Traits\TournamentsTable;

use App\Models\Game;
use App\Models\Tournament;

trait PlayOffTrait
{
    public function getPlayoffData(Tournament $tournament)
    {
        $data = [];
        foreach ($tournament->getRounds() as $i => $round) {
            $games = [];
            if ($i === $tournament->num_round && $tournament->is_generated_playoff) {
                $name = 'Финал';
                /** @var Game $gameFirstSecondPlace */
                $gameFirstSecondPlace = $round->first();

                $getPlaceFinal = function ($comparsion) {
                    switch ($comparsion) {
                        case null:
                            return '?';
                        case 0:
                            return 'Ничья';
                        case -1:
                            return '2 место';
                        case 1:
                            return '1 место';
                        default:
                            return '';
                    }
                };

                $games[] = [
                    'team1' => [
                        'name' => $gameFirstSecondPlace->team_1->name,
                        'place' => $getPlaceFinal($gameFirstSecondPlace->comparsionTeamsCount()),
                        'count' => $gameFirstSecondPlace->count_team_1,
                        'id' => $gameFirstSecondPlace->id_team_1,
                    ],
                    'team2' => [
                        'name' => $gameFirstSecondPlace->team_2->name,
                        'place' => $getPlaceFinal($gameFirstSecondPlace->comparsionTeamsCount(true)),
                        'count' => $gameFirstSecondPlace->count_team_2,
                        'id' => $gameFirstSecondPlace->id_team_2,
                    ],
                ];

                if($tournament->currentRoundTeamsCount() !== 2) {

                    /** @var Game $gameThirdPlace */
                    $gameThirdPlace = $round->last();

                    $getPlaceSecond = function ($comparsion) {
                        switch ($comparsion) {
                            case null:
                                return '?';
                            case 0:
                                return 'Ничья';
                            case 1:
                                return '3 место';
                            default:
                                return '';
                        }
                    };

                    $games[] = [
                        'team1' => [
                            'name' => $gameThirdPlace->team_1->name,
                            'place' => $getPlaceSecond($gameThirdPlace->comparsionTeamsCount()),
                            'count' => $gameThirdPlace->count_team_1,
                            'id' => $gameThirdPlace->id_team_1,
                        ],
                        'team2' => [
                            'name' => $gameThirdPlace->team_2->name,
                            'place' => $getPlaceSecond($gameThirdPlace->comparsionTeamsCount(true)),
                            'count' => $gameThirdPlace->count_team_2,
                            'id' => $gameThirdPlace->id_team_2,
                        ],
                    ];
                }

            } else {
                $name = "1/" . $round->count() . " финала";

                $getPlace = function ($comparsion) {
                    switch ($comparsion) {
                        case null:
                            return '?';
                        case 0:
                            return 'Ничья';
                        case 1:
                            return 'Победа';
                        default:
                            return '';
                    }
                };

                foreach ($round as $game) {
                    $games[] = [
                        'team1' => [
                            'name' => $game->team_1->name,
                            'place' => $getPlace($game->comparsionTeamsCount()),
                            'count' => $game->count_team_1,
                            'id' => $game->id_team_1,
                        ],
                        'team2' => [
                            'name' => $game->team_2->name,
                            'place' => $getPlace($game->comparsionTeamsCount(true)),
                            'count' => $game->count_team_2,
                            'id' => $game->id_team_2,
                        ],
                    ];
                }

            }
            $data[] = [
                'name' => $name,
                'games' => $games,
            ];
        }
        return $data;
    }
}
