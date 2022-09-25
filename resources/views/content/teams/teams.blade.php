<div class="main">
    <div class="title">Команды</div>
    <br>
    <table class = "list-teams">
        <tr class="team">
            <td>{{__("Название команды")}}</td>
            <td>{{__("Игроки команды")}}</td>
            <td>{{__("Роботы команды")}}</td>
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
                    <ol>
                        @foreach($team["listRobots"] as $robot)
                            <li>
                                {{ $robot->first()->name }}
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td>
                    @livewire('add-team',["id_place" => $id_place, "current_team" => $team['team']->id])
                </td>
            </tr>
        @endforeach

    </table>

    <br>
    @livewire('add-team',["id_place" => $id_place])
    <br>
</div>
