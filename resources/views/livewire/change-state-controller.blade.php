<div class="state-change">
    <span wire:poll.1000ms="updateTime"></span>

    @push('scripts')
        <script>
            function notify() {
                let time = @this.
                get('time');
                let id_state = @this.
                get('id_state');
                let is_sounded = @this.
                get('is_sounded');
                let max_seconds_match = @this.
                get('max_seconds_match');

                if (!is_sounded && id_state === 2 && time >= max_seconds_match) {
                    let audio = document.getElementById("audioelement");
                    audio.play();
                    @this.
                    set('is_sounded', true);
                    Livewire.emit('is_sounded');
                    if ('vibrate' in navigator) {
                        // Вибрация подерживается
                        navigator.vibrate([1000]);
                    }
                }
            }

            setInterval(notify, 500);

            function audio_stop() {
                let audio = document.getElementById("audioelement");
                audio.pause();
                audio.currentTime = 0;
            }

        </script>
    @endpush
    @stack('scripts')

    @switch($game->id_state)
        @case(0)
        <p>{{__('Игра завершена')}}</p>
        <a href="#!" class="button big-button" wire:click="time_new">
            @if(App::isLocale('ru'))
                {{ __("ПРОДОЛЖИТЬ ИГРУ С ".($game->num_periods+1)." ТАЙМА") }}
            @else
                {{ __("CONTINUE THE GAME FROM THE ".($game->num_periods+1)." HALF") }}
            @endif
        </a>
        @break
        @case(1)
        <a href="#!" class="button big-button" wire:click="game_start">
            {{ __('НАЧАТЬ ИГРУ') }}
        </a>
        @break
        @case(2)
        <div>
            <a href="#!" class="button big-button" onclick="audio_stop()" wire:click="game_stop">
                {{ __('ПАУЗА') }}
            </a>
        </div>
        <br/>
        <br/>
        <div>
            <a href="#!" class="button big-button" onclick="audio_stop()" wire:click="time_exit">
                @if(App::isLocale('ru'))
                    {{ __("ЗАВЕРШИТЬ $game->num_periods ТАЙМ") }}
                @else
                    {{ __("FINISH $game->num_periods HALF") }}
                @endif
            </a>
        </div>

        @break
        @case(3)
        <div>
            <a href="#!" class="button big-button" wire:click="game_continue">
                {{ __('ВОЗОБНОВИТЬ ИГРУ') }}
            </a>
        </div>
        <br/>
        <br/>
        <div>
            <a href="#!" class="button big-button" onclick="audio_stop()" wire:click="time_exit">
                @if(App::isLocale('ru'))
                    {{ __("ЗАВЕРШИТЬ $game->num_periods ТАЙМ") }}
                @else
                    {{ __("FINISH $game->num_periods HALF") }}
                @endif
            </a>
        </div>
        @break
        @case(4)
        <div>
            <a href="#!" class="button big-button" wire:click="time_new">
                @if(App::isLocale('ru'))
                    {{ __("НАЧАТЬ ".($game->num_periods+1)." ТАЙМ") }}
                @else
                    {{ __("START $game->num_periods HALF") }}
                @endif
            </a>
        </div>
        <br/>
        <br/>
        <div>
            <a href="#!" class="button big-button" onclick="audio_stop()" wire:click="game_exit">
                {{ __('ЗАВЕРШИТЬ ИГРУ') }}
            </a>
        </div>
        @break
    @endswitch
    <audio class="audio" loop style="visibility: hidden" controls id="audioelement">
        <source src="/assets/audio/Beginning Of Fight.mp3" type="audio/mpeg"/>
    </audio>
</div>
