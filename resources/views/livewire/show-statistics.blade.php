<div wire:poll.5000ms="refresh">

    <section class="tournament">
        <p>Завершенные игры</p>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Дата @include("layouts.filter", ['type'=>'date']) </th>
                    <th>Время</th>
                    <th>Турнир @include("layouts.filter", ['type'=>'tournamentName'])</th>
                    <th>Команды @include("layouts.filter", ['type'=>'team'])</th>
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

        @if($batch == $games->count())
        <ul class="actions special">
            <li>
                <a href="#!" class="button big-button" wire:click="load_more">Загрузить еще записи</a>
            </li>
        </ul>
        @endif
    </section>

</div>
