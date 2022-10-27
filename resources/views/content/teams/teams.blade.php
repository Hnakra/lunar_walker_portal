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
                <li>@livewire('add-team')</li>
{{--                <li><a href="#" class="button big-button">ДОБАВИТЬ КОМАНДУ</a></li>--}}
            </ul>
        </div>
        <a href="#one" class="more scrolly"></a>
    </section>

    <section id="one" class="wrapper style5">

        @foreach($teamsWithPlayers as $team)
        <section class="tournament">

            <h4 class="title1">команда "{{$team['team']->name}}"</h4>
            <div class="edit-wrapper">
                @livewire('add-team',["current_team" => $team['team']->id])
            </div>

            <div class="block">
                <div class="column">
                    <h5 class="title2"><div>Игроки</div></h5>
                    @foreach($team["listUsers"] as $user)
                    <div class="line"><img class="avatar" src="{{$user -> first() -> profile_photo_url}}" alt="аватарка" /><span> </span><span class="text">{{ $user->first()->name }}</span></div>
                    @endforeach
                </div>
{{--                {{print_r($team["listRobots"])}}--}}
                <div class="column right-column">
                    <div>
                        <div><h5 class="title2">Роботы</h5></div>
                        @foreach($team["listRobots"] as $robot)
                        <div class="line"><img class="avatar" src="images/banner.jpg" alt="аватарка" /><span> </span><span class="text"> {{($robot->first()->name)}} </span></div>
{{--                            {{$robot->name}}--}}
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endforeach


    </section>
</div>

</div>
