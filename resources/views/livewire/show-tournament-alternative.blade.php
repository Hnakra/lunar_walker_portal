<div class="component">
    <a wire:click="createShowModal" class="show-modal">{{$tournament->name}}</a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{$tournament->name}}
        </x-slot>
        <x-slot name="content">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('alternativeVisible')">
                {{ __('SWAP') }}
            </x-jet-secondary-button>
            <section class="tournament">
                <h5>Площадка: <a href="/places/{{$tournament->place->id}}"
                                 class="link-name1">{{$tournament->place->name}}</a></h5>
                <h5>Дата/время проведения:{{$tournament->date_time}}</h5>

                @for($i = 1; $i <= $tournament->numGroups(); $i++)
                    @php
                        $teamsInGroup = $tournament->getTeamsByGroupId($i);
                        $gamesInGroup = $tournament->getGamesByGroupId($i);
                    @endphp
                    <div>
                        <table>
                            <thead>
                            <tr>
                                <th>{{\App\Models\TeamsInTournament::getGroupNameByIdGroup($teamsInGroup->first()->group)}}</th>
                                <th>Команда</th>
                                @for($j = 1; $j <= $teamsInGroup->count(); $j++)
                                    <th>{{$j}}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teamsInGroup as $j => $team)
                                <tr>
                                    <td>{{$j+1}}</td>
                                    <td>{{$team->name}}</td>
                                    @for($z = 1; $z <= $teamsInGroup->count(); $z++)
                                        <td>
                                            @if($j+1 === $z)
                                                XXX
                                            @else
                                                @if($j+1 < $z)
                                                    {{--Верхнеуголь--}}
                                                    @php
                                                        $game = $gamesInGroup->where('id_team_1', $teamsInGroup[$j]->id)
                                                        ->where('id_team_2', $teamsInGroup[$z-1]->id)
                                                        ->first()
                                                    @endphp

                                                    @if($game->id_state === 1)
                                                        -
                                                    @else
                                                        {{$game->count_team_1}}:{{ $game->count_team_2}}
                                                    @endif

                                                @else
                                                    {{--Нижееуголь--}}
                                                    @php
                                                        $game = $gamesInGroup->where('id_team_2', $teamsInGroup[$j]->id)
                                                            ->where('id_team_1', $teamsInGroup[$z-1]->id)
                                                            ->first()
                                                    @endphp
                                                    @if($game->id_state === 1)
                                                        -
                                                    @else
                                                        {{$game->count_team_2}}:{{ $game->count_team_1}}
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    @endfor

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endfor

            </section>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
