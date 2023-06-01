<div class="component">
    <a wire:click="createShowModal" class="show-modal">{{$tournament->name}}</a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{$tournament->name}}
        </x-slot>
        <x-slot name="content">

            @if($isExistsAlternativeVisible)
                <x-jet-secondary-button class="button-secondary" wire:click="$toggle('alternativeVisible')">
                    {{ __('SWAP') }}
                </x-jet-secondary-button>
            @endif
            <section class="tournament">
                <h5>Площадка: <a href="/places/{{$tournament->place->id}}"
                                 class="link-name1">{{$tournament->place->name}}</a></h5>
                <h5>Дата/время проведения:{{$tournament->date_time}}</h5>

                @foreach($groups as $i => $group)
                    <div>
                        <table class="tournament-table">
                            <thead>
                            <tr>
                                @foreach($group['head'] as $k => $item)
                                    <th @if($group['headDescription'][$k] !== "") title="{{$group['headDescription'][$k]}}" @endif>
                                        {{$item}}
                                    </th>
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>


                            @for($j = 0; $j < count($group[0]['games']); $j++)
                                @php
                                    $team = $group[$j];
                                @endphp

                                <tr>
                                    <td title="Номер">{{$team['number']}}</td>
                                    <td>{{$team['teamName']}}</td>
                                    @foreach($team['games'] as $z => $game)
                                        @if($game === 'X')
                                            <td class="x"></td>
                                        @else
                                            <td title="{{$team['gameDescription'][$z]}}">
                                                {{$game}}
                                            </td>
                                        @endif
                                    @endforeach

                                    <td title="{{$team['pointsDescription']}}">{{$team['points']}}</td>
                                    <td title="{{$team['differentDescription']}}">{{$team['different']}}</td>
                                    <td title="{{$team['placeDescription']}}">{{$team['place']}}</td>
                                </tr>
                            @endfor

                            </tbody>

                        </table>
                    </div>
                @endforeach









{{--


                @php
                    $score = [];
                    $count_win = [];
                    $count_lose = [];
                @endphp

                @for($i = 1; $i <= $tournament->numGroups(); $i++)
                    @php
                        $teamsInGroup = $tournament->getTeamsByGroupId($i);
                        $gamesInGroup = $tournament->getGamesByGroupId($i);
                        $score[$i] = [];
                        $count_win[$i] = [];
                        $count_lose[$i] = [];
                    @endphp
                    <div>
                        <table class="tournament-table">
                            <thead>
                            <tr>
                                <th>{{\App\Models\TeamsInTournament::getGroupNameByIdGroup($teamsInGroup->first()->group)}}</th>
                                <th>Команда</th>
                                @for($j = 1; $j <= $teamsInGroup->count(); $j++)
                                    <th title="{{$teamsInGroup[$j-1]->name}}">{{$j}}</th>
                                @endfor
                                <th title="Очков добыто">O</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teamsInGroup as $j => $team)
                                <tr>
                                    <td title="Номер">{{$j+1}}</td>
                                    <td>{{$team->name}}</td>
                                    @for($z = 1; $z <= $teamsInGroup->count(); $z++)

                                        @if($j+1 === $z)
                                            <td class="x"></td>
                                        @else

                                            @if($j+1 < $z)
                                                --}}{{--Верхнеуголь--}}{{--
                                                @php
                                                    $game = $gamesInGroup->where('id_team_1', $teamsInGroup[$j]->id)
                                                    ->where('id_team_2', $teamsInGroup[$z-1]->id)
                                                    ->first()
                                                @endphp

                                                @if($game->id_state === 1)
                                                    <td title="Идет игра">
                                                        ...
                                                    </td>
                                                @else
                                                    <td title="
                                                    @php
                                                        if($game->count_team_1 === $game->count_team_2){
                                                            echo "Ничья";
                                                        } else {
                                                            if($game->count_team_1 > $game->count_team_2){
                                                                echo "$team->name выиграла";
                                                            } else {
                                                                echo "$team->name проиграла";
                                                            }
                                                        }

                                                    @endphp
                                                        ">
                                                        {{$game->count_team_1}}:{{ $game->count_team_2}}
                                                    </td>
                                                @endif

                                            @else
                                                --}}{{--Нижееуголь--}}{{--
                                                @php
                                                    $game = $gamesInGroup->where('id_team_2', $teamsInGroup[$j]->id)
                                                        ->where('id_team_1', $teamsInGroup[$z-1]->id)
                                                        ->first()
                                                @endphp
                                                @if($game->id_state === 1)
                                                    <td title="Идет игра">
                                                        ...
                                                    </td>
                                                @else
                                                    <td title="
                                                    @php
                                                        if($game->count_team_2 === $game->count_team_1){
                                                            echo "Ничья";
                                                        } else {
                                                            if($game->count_team_2 > $game->count_team_1){
                                                                echo "$team->name выиграла";
                                                            } else {
                                                                echo "$team->name проиграла";
                                                            }
                                                        }

                                                    @endphp
                                                        ">
                                                        {{$game->count_team_2}}:{{ $game->count_team_1}}
                                                    </td>
                                                @endif
                                            @endif

                                        @endif


                                    @endfor
                                    @php
                                        $score[$i][$j] = 0;
                                        $count_win[$i][$j] = 0;
                                        $count_lose[$i][$j] = 0;
                                        $gamesThisTeam1 = $gamesInGroup->where('id_team_1', $teamsInGroup[$j]->id);
                                        foreach ($gamesThisTeam1 as $game){
                                            if($game->count_team_1 > $game->count_team_2){
                                                $score[$i][$j] += 2;
                                            }
                                            if($game->count_team_1 == $game->count_team_2){
                                                $score[$i][$j] += 1;
                                            }
                                        }

                                        $gamesThisTeam2 = $gamesInGroup->where('id_team_2', $teamsInGroup[$j]->id);
                                        foreach ($gamesThisTeam2 as $game){
                                            if($game->count_team_2 > $game->count_team_1){
                                                $score[$i][$j] += 2;
                                            }
                                            if($game->count_team_2 == $game->count_team_1){
                                                $score[$i][$j] += 1;
                                            }
                                        }
                                    @endphp
                                    <td>
                                        {{$score[$i][$j]}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endfor--}}

            </section>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
