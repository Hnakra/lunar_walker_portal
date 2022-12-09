<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>статистика игр</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>
<section id="one" class="wrapper style5">
    <div class="inner">
        <section class="tournament">
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Турнир</th>
                        <th>Команды</th>
                        <th>Счет</th>
                        <th>Состояние</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{$game->date}}</td>
                            <td>{{$game->time}}</td>
                            <td>{{$game->tournamentName}}</td>
                            <td>{{$game->t1_name}} VS {{$game->t2_name}}</td>
                            <td>@livewire('show-count', ["game" => $game, "number_team" => 1]):@livewire('show-count', ["game" => $game, "number_team" => 2])</td>
                            <td>@livewire('show-state-game', ['id_game' => $game->id])</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>
