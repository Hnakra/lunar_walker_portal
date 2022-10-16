<div class="main">
    <div class="title">Команды</div>
    <br>
    <table class = "list-teams">
        <tr class="team">
            <td>{{__("Название команды")}}</td>
            <td>{{__("Игроки команды")}}</td>
            <td></td>
        </tr>
        @foreach($teamsWithPlayers as $team)
            <tr class="team with-hr">
                <td>{{$team['team']->name}}</td>
                <td>
                    <ol>
                        @foreach($team["listUsers"] as $user)
                            <li>
                                {{ $user->first()->name }}
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td>
                    @livewire('add-team',["current_team" => $team['team']->id])
                </td>
            </tr>
        @endforeach

    </table>

    <br>
    @livewire('add-team')
    <br>
</div>
