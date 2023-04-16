<div class="main">
    <div class="title">Команды</div>
    <!-- Banner -->
    <section id="banner">
        <div class="inner">
            <h2>команды</h2>
            <!--<p>Another fine responsive<br />
                site template freebie<br />
                crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
            <ul class="actions special">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <li>@livewire('team-form')</li>
                @endif
{{--                <li><a href="#" class="button big-button">ДОБАВИТЬ КОМАНДУ</a></li>--}}
            </ul>
        </div>
        <a href="#one" class="more scrolly">Читать далее</a>
    </section>

    <section id="one" class="wrapper style5">

        @foreach($teamsWithPlayers as $team)
        <section class="tournament">

            <h4 class="title1">команда "{{$team['team']->name}}"</h4>
            @if($team['trainer'])
                <div class = "trainer">
                    Тренер:
                    <span class="text"> @livewire('show-user', ['user' => $team['trainer']])</span>
                </div>
            @endif

            <div class="edit-wrapper">
                @if(Auth::check() && Auth::user()->isAdmin())
                    @livewire('remove-team',["current_team" => $team['team']->id])
                @endif

                @if(Auth::check() && Auth::user()->isOwnerOrAdmin($team['trainer']?$team['trainer']->id:0))
                    @livewire('team-form',["current_team" => $team['team']->id])
                @endif
            </div>

            <div class="team-wrapper">
                <div class="column">
                    <h5 class="title2"><div>Игроки</div></h5>
                    @foreach($team["listUsers"] as $user)
                        <div class="line"><img class="avatar" src="{{$user ->photo}}" alt="аватарка" />
                            <span class="text"> @livewire('show-user', ['user' => $user])</span>
                        </div>
                    @endforeach
                </div>
                <div class="column right-column">
                    <div>
                        <div><h5 class="title2">Роботы</h5></div>
                        @foreach($team["listRobots"] as $robots)
                            @foreach($robots as $robot)
                                <div class="line"><img class="avatar" src="{{$robot->photo}}" alt="аватарка" />
                                    <span class="text"> @livewire("show-robot", ['robot' => $robot]) </span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endforeach


    </section>
</div>

</div>
