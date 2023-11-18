<span wire:poll.1000ms="refresh">
    @isset($game)
         @switch($game->id_state)
            @case(0)
            <i class="fas fa-check" title="{{__('Игра завершена')}}"></i> {{__('Игра завершена')}}
            @break
            @case(1)
            <i class="fas fa-stop-circle" title="{{__('Игра не началась')}}"></i> {{__('Игра не началась')}}
            @break
            @case(2)
            <i class="fas fa-play" title="
                @if(App::isLocale('ru'))
                    {{__(" Идет $game->num_periods тайм")}}
                @else
                    {{__('It\'s'.$game->num_periods.' half')}}
                @endif
            "></i>
            @if(App::isLocale('ru'))
                {{__(" Идет $game->num_periods тайм(".$this->getTime().")")}}
            @else
                {{__("It's $game->num_periods half (".$this->getTime().")")}}
            @endif
            @break
            @case(3)
            <i class="fas fa-pause" title="
                @if(App::isLocale('ru'))
                    {{__("Пауза $game->num_periods тайма")}}
                @else
                    {{__($game->num_periods.' half is break')}}
                @endif
            "></i>
            @if(App::isLocale('ru'))
                {{__("Пауза $game->num_periods тайма(".$this->getFixedTime().')')}}
            @else
                {{__($game->num_periods.' half is break('.$this->getFixedTime().')')}}
            @endif
            @break
            @case(4)
            <i class="fas fa-stopwatch" title="
                @if(App::isLocale('ru'))
                    {{ __("Завершен $game->num_periods тайм")}}
                @else
                    {{__($game->num_periods.' half is completed')}}
                @endif
            "></i>
            @if(App::isLocale('ru'))
                {{ __("Завершен $game->num_periods тайм")}}
            @else
                {{__($game->num_periods.' half is completed')}}
            @endif
            @break
        @endswitch
    @endisset
</span>
