<div wire:poll.5000ms="refresh">

    <section class="tournament">
        <p>Текущие игры</p>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Команды</th>
                    <th>Счет</th>
                    <th>Состояние</th>
                </tr>
                </thead>
                <tbody>
                @foreach($freshGames as $game)
                    <tr>
                        <td>{{$game->date}}</td>
                        <td>{{$game->time}}</td>
                        <td>{{$game->t1_name}} VS {{$game->t2_name}}</td>
                        <td>@livewire('show-count', ["game" => $game, "number_team" => 1], key("count-1-".$game->id))
                            :@livewire('show-count', ["game" => $game, "number_team" => 2], key("count-2-".$game->id))</td>
                        <td>@livewire('show-state-game', ['id_game' => $game->id], key("state-".$game->id))</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </section>

    <section class="tournament">
        <p>Завершенные игры</p>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Турнир</th>
                    <th>Команды</th>
                    <th>Счет</th>
                </tr>
                </thead>
                <tbody>
                @foreach($games as $game)
                    <tr>
                        <td>{{$game->date}}</td>
                        <td>{{$game->time}}</td>
                        <td>{{$game->tournamentName}}</td>
                        <td>{{$game->t1_name}} VS {{$game->t2_name}}</td>
                        <td>{{$game->count_team_1}}:{{$game->count_team_2}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </section>

</div>
