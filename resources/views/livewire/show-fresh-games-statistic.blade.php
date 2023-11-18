<div wire:poll.5000ms="refresh">
    <section class="tournament">
        <p>{{__('Текущие игры')}}</p>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>{{__('Дата')}}</th>
                    <th>{{__('Время')}}</th>
                    <th>{{__('Команды')}}</th>
                    <th>{{__('Счет')}}</th>
                    <th>{{__('Состояние')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($freshGames as $game)
                    <tr>
                        <td>{{$game->date}}</td>
                        <td>{{$game->time}}</td>
                        <td>{{$game->t1_name}} VS {{$game->t2_name}}</td>
                        <td>{{$game->count_team_1}}:{{$game->count_team_2}}</td>
                        <td>
                            @if($game->id_state == 1)
                                {{__('Игра не началась')}}
                            @else
                                @livewire('show-state-game', ['id_game' => $game->id], key("state-".$game->id))
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </section>
</div>
