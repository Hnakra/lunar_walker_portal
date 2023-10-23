<span wire:poll.1000ms="refresh">
    @isset($game)
         @switch($game->id_state)
            @case(0)
            <i class="fas fa-check" title="Игра завершена"></i> Игра завершена
            @break
            @case(1)
            <i class="fas fa-stop-circle" title="Игра не началась"></i> Игра не началась
            @break
            @case(2)
            <i class="fas fa-play" title="Идет {{$game->num_periods}} тайм"></i> Идет {{$game->num_periods}} тайм({{$this->getTime()}})
            @break
            @case(3)
            <i class="fas fa-pause" title="Пауза {{$game->num_periods}} тайма"></i> Пауза {{$game->num_periods}} тайма({{$this->getFixedTime()}})
            @break
            @case(4)
            <i class="fas fa-stopwatch" title="Завершен {{$game->num_periods}} тайм"></i> Завершен {{$game->num_periods}} тайм
            @break
        @endswitch
    @endisset
</span>
