<span wire:poll.1000ms="refresh">
    @isset($game)
         @switch($game->id_state)
            @case(0)
            Игра завершена
            @break
            @case(1)
            Игра не началась
            @break
            @case(2)
            Идет {{$game->num_periods}} тайм({{$this->getTime()}})
            @break
            @case(3)
            Пауза {{$game->num_periods}} тайма({{$this->getFixedTime()}})
            @break
            @case(4)
            Завершен {{$game->num_periods}} тайм
            @break
        @endswitch
    @endisset
</span>
