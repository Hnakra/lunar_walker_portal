<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИГРЫ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            @if(Auth::check() && !Auth::user()->isUser())
                <li>@livewire('add-tournament')</li>
            @endif
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
                    @if(Auth::check() && !Auth::user()->isUser())
                        @livewire('add-game', ['id_tournament' => $tournament->id, 'last_datetime' => $tournament->date_time])
                    @endif
                </li>
            </ul>

            <div class="edit-wrapper">
                @if(Auth::check() && !Auth::user()->isUser())
                <a href="#"  class="button-edit" title="редактировать турнир"><i class="fa fa-edit" style="font-size:30px"></i></a>
                @endif
            </div>

        </section>
        @endforeach
    </div>
</section>


