<span wire:poll.1000ms="refresh">
    @if($number_team == 1)
        {{$game->count_team_1}}
    @else
        {{$game->count_team_2}}
    @endif
</span>




