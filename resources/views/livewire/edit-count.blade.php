<div class = "counter-content">
    @livewire('show-state-game', ['id_game' => $game->id])
    <br/> <br/>
    <table>
        <tr>
            <td>
                {{$game->t1_name}}
            </td>
        </tr>
        <tr>
            <td>
                <a href="#!" wire:click="minus(1)" @if($this->game->id_state != 2) class="disabled" @endif ><i class="fa fa-minus"></i></a>
                {{$game->count_team_1}}
                <a href="#!" wire:click="plus(1)" @if($this->game->id_state != 2) class="disabled" @endif ><i class="fa fa-plus"></i></a>
            </td>
        </tr>
        <tr>
            <td>
                {{$game->t2_name}}
            </td>
        </tr>
        <tr>
            <td>
                <a href="#!" wire:click="minus(2)" @if($this->game->id_state != 2) class="disabled" @endif ><i class="fa fa-minus"></i></a>
                {{$game->count_team_2}}
                <a href="#!" wire:click="plus(2)" @if($this->game->id_state != 2) class="disabled" @endif ><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    </table>
    <div class="table-wrapper" style=" height: 200px">
        <table>
            @foreach($log as $l)
                <tr>
                    <td>{{$l->time}}</td>
                    <td>{{$l->name}} {{$l->difference}}</td>
                </tr>
            @endforeach

        </table>
    </div>
    <div>
        @livewire('change-state-controller', ['id_game'=>$game->id])
    </div>

</div>
