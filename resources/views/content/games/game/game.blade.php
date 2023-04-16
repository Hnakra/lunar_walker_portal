<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИНФОРМАЦИЯ ОБ ИГРЕ<br>{{$team_1->name}} VS {{$team_2->name}}</h2>
        <h4>{{$game->date_time}}</h4>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            @if(Auth::check() && Auth::user()->isOwnerOrAdmin($organizer->id))
            <li><a href="/game/{{$game->id}}/counter" class="button big-button">ВЕСТИ СЧЁТ</a></li>
            @endif
        </ul>
    </div>
</section>


<section>
    <div>
        <div class = "edit-bar">

            @if(Auth::check() && Auth::user()->isOwnerOrAdmin($organizer->id))
                @livewire('remove-game',["current_game" => $game->id])
                @livewire('game-form', ['id_tournament' => $tournament->id, 'current_game' => $game->id])

            @endif

        </div>
        <div class = "state-game">@livewire('show-state-game', ['id_game' => $game->id])</div>
        <div class="block-game">
            <div id="block1">
                <div class="rectangle3">@livewire('show-count', ["game" => $game, "number_team" => 1])</div>
                <div class="heading">{{$team_1->name}}<hr class="hr-line1"></div>

                <div class="subtitle">Состав команды</div>
                @foreach($users_team1 as $user)
                    {{--                <div class="rectangle1 text-in-rectangle"><a href="#" class="link-name1">{{$user->name}}</a></div>--}}
                    <div class="rectangle1 text-in-rectangle link-name1">
                        @livewire('show-user', ['user' => $user])
                    </div>
                @endforeach

                <div class="subtitle">Роботы</div>
                @foreach($list1Robots as $robots)
                    @foreach($robots as $robot)
                        {{--                    <div class="rectangle1-1 text-in-rectangle"><a href="#" class="link-name1"> {{($robot->name)}}</a></div>--}}
                        <div class="rectangle1-1 text-in-rectangle link-name1">
                            @livewire("show-robot", ['robot' => $robot])
                        </div>
                    @endforeach
                @endforeach
                @if($trainer_1)
                    <div class="subtitle">Тренер</div>

                    <div class="rectangle1 text-in-rectangle link-name1">
                        @livewire('show-user', ['user' => $trainer_1])
                    </div>
                @endif

            </div>
            <div id="block2">
                <div class="rectangle4">@livewire('show-count', ["game" => $game, "number_team" => 2])</div>
                <div class="heading">{{$team_2->name}}<hr class="hr-line2"></div>
                <div class="subtitle">Состав команды</div>
                @foreach($users_team2 as $user)
                    {{--                <div class="rectangle2 text-in-rectangle"><a href="#" class="link-name2">{{$user->name}}</a></div>--}}
                    <div class="rectangle2 text-in-rectangle link-name2">
                        @livewire('show-user', ['user' => $user])
                    </div>
                @endforeach

                <div class="subtitle">Роботы</div>
                @foreach($list2Robots as $robots)
                    @foreach($robots as $robot)
                        {{--                    <div class="rectangle2-2 text-in-rectangle"><a href="#" class="link-name2">{{$robot->name}}</a></div>--}}
                        <div class="rectangle2-2 text-in-rectangle link-name2">
                            @livewire("show-robot", ['robot' => $robot])
                        </div>

                    @endforeach
                @endforeach
                @if($trainer_2)
                    <div class="subtitle">Тренер</div>
                    <div class="rectangle2 text-in-rectangle link-name2">
                        @livewire('show-user', ['user' => $trainer_2])
                    </div>
                @endif

            </div>

        </div>
    </div>


</section>
<div class="block-second">
    @if($tournament->isGrouped())
        <div class = "state-game">
            Группа {{$game->groupName()}}
        </div>
        <br>
    @endif
    <div class="table">
        <table>
            <tr>
                <td class="subtitle">Турнир</td>
                <td align="right"><a href="/games" class="link-name1">{{$tournament->name}}</a></td>
            </tr>
            <tr>
                <td class="subtitle">Площадка</td>
                <td align="right"><a href="/places/{{$place->id}}" class="link-name1">{{$place->name}}</a></td>
            </tr>
            <tr>
                <td class="subtitle">Организатор</td>
                <td align="right"><div class="link-name1">@livewire('show-user', ['user' => $organizer])</div></td>
            </tr>
            <tr>
                <td class="subtitle">Длительность 1 тайма</td>
                <td align="right">{{$game->max_seconds_match}} секунд</td>
            </tr>

        </table>
    </div>
</div>
