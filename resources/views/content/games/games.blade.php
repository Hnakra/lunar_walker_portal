<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИГРЫ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            <li>@livewire('add-tournament')</li>
{{--            <li><a href="#" class="button big-button">СОЗДАТЬ ТУРНИР</a></li>--}}
        </ul>
    </div>
    <a href="#one" class="more scrolly"></a>
</section>

<section id="one" class="wrapper style5">
    <div class="inner">
        @foreach($tournaments as $tournament)
        <section class="tournament">
            <h4>{{$tournament->name}}</h4>
            <h5>{{$tournament->place_name}}</h5>
            <h5>{{$tournament->date_time}}</h5>
{{--            {{print_r($tournament)}}--}}
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Время</th>
                        <th>Команды</th>
                        <th>Счет</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament->games as $game)
                        <tr>
                            <td>{{$game->date_time}}</td>
                            <td>{{$game->name_team_1}} VS {{$game->name_team_2}}</td>
                            <td>{{$game->count_team_1}}:{{$game->count_team_2}}</td>
                            <td><a href="/game/{{$game->id}}" title="информация об игре" class="points">...</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <ul class="actions special">
                <li>
                    @livewire('add-game', ['id_tournament' => $tournament->id, 'last_datetime' => $tournament->date_time])
                </li>
            </ul>
        </section>
        @endforeach
    </div>
</section>


