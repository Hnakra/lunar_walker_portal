<div class = "counter-content">
    <table>
        <tr>
            <td>
                {{$game->t1_name}}
            </td>
        </tr>
        <tr>
            <td>
                <a href="#!" wire:click="minus(1)"><i class="fa fa-minus"></i></a>
                {{$game->count_team_1}}
                <a href="#!" wire:click="plus(1)"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
        <tr>
            <td>
                {{$game->t2_name}}
            </td>
        </tr>
        <tr>
            <td>
                <a href="#!" wire:click="minus(2)"><i class="fa fa-minus"></i></a>
                {{$game->count_team_2}}
                <a href="#!" wire:click="plus(2)"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    </table>
    <div class="table-wrapper" style=" height: 400px">
        <table>
            @foreach($log as $l)
                <tr>
                    <td>{{$l->time}}</td>
                    <td>{{$l->name}} {{$l->difference}}</td>
                </tr>
            @endforeach

        </table>
    </div>

</div>
