@php
/**
 * @var $tournament \App\Models\Tournament
*/

@endphp

<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИГРЫ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            @if(Auth::check() && !Auth::user()->isUser())
                <li>@livewire('forms.tournament-form')</li>
            @endif
{{--            <li><a href="#" class="button big-button">СОЗДАТЬ ТУРНИР</a></li>--}}
        </ul>
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

<section id="one" class="wrapper style5">
    <div class="inner">
        @foreach($tournaments as $tournament)
        <section class="tournament">
            <h4>@livewire('show-tournament', ['tournament' => $tournament], key("tournament-$tournament->id")){{--{{$tournament->name}}--}}</h4>
            <h5>{{$tournament->place_name}}</h5>
            <h5>{{$tournament->date_time}}</h5>
{{--            {{print_r($tournament)}}--}}
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Cтатус</th>
                        @if($tournament->isGrouped())
                            <th>Группа</th>
                        @endif
                        <th>Время</th>
                        <th>Команды</th>
                        <th>Счет</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament->games as $game)
                        <tr>
                            <td>
                                @switch($game->id_state)
                                    @case(0)
                                    <i class="fas fa-check" title="Игра завершена"></i>
                                    @break
                                    @case(1)
                                    <i class="fas fa-stop-circle" title="Игра не началась"></i>
                                    @break
                                    @case(2)
                                    <i class="fas fa-play" title="Идет {{$game->num_periods}} тайм"></i>
                                    @break
                                    @case(3)
                                    <i class="fas fa-pause" title="Пауза {{$game->num_periods}} тайма"></i>
                                    @break
                                    @case(4)
                                    <i class="fas fa-stopwatch" title="Завершен {{$game->num_periods}} тайм"></i>
                                    @break
                                @endswitch
                            </td>
                            @if($tournament->isGrouped())
                                <td>{{$game->groupName()}}</td>
                            @endif
                            <td>{{$game->getTime()}}</td>
                            <td>{{$game->name_team_1}} VS {{$game->name_team_2}}</td>
                            <td>{{$game->count_team_1}}:{{$game->count_team_2}}</td>
                            <td><a href="/game/{{$game->id}}" title="информация об игре" class="points">...</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            @if(!$tournament->isGenerated && Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator))
                <ul class="actions special">
                    <li>
                        @livewire('group-teams-in-tournament', ['id_tournament' => $tournament->id])
                    </li>
                </ul>
            @endif

            @if(!$tournament->isGenerated && Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator))
                <ul class="actions special">
                    <li>
                        @livewire('forms.tournament-table-form', ['id_tournament' => $tournament->id])
                    </li>
                </ul>
            @endif

            @if(Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator) && $tournament->isDoneAllVsAll() && !$tournament->is_playoff)
                <ul class="actions special">
                    <li>
                        @livewire('generate-playoff', ['id_tournament' => $tournament->id])
                    </li>
                </ul>
            @endif

            @if(Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator) && $tournament->hasCreatablePlayoffGame())
                <ul class="actions special">
                    <li>
                        @livewire('forms.game-form', ['id_tournament' => $tournament->id, 'last_datetime' => $tournament->date_time])
                    </li>
                </ul>
            @endif

            @if(Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator) && ($tournament->isDonePlayoff() || $tournament->isFinalRoundPlayoff()))
                <ul class="actions special">
                    <li>
                        @livewire('forms.round-tournament-playoff-form', ['id_tournament' => $tournament->id])
                    </li>
                </ul>
            @endif


            <div class="edit-wrapper">
                {{--кнопка, при нажатии которой появляется модальное окно редактирования турнира--}}
                @if(Auth::check() && Auth::user()->isOwnerOrAdmin($tournament->id_creator))
                        @livewire('removes.remove-tournament',["current_tournament" => $tournament->id])
                        @livewire('forms.tournament-form', ['current_tournament' => $tournament->id])
                @endif
            </div>

        </section>
        @endforeach
    </div>
</section>


