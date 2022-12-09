<div class = "state-change">
    @switch($game->id_state)
        @case(0)
            <p>Игра завершена</p>
        @break
        @case(1)
            <a href="#!" class="button big-button" wire:click="game_start">
                {{ __('НАЧАТЬ ИГРУ') }}
            </a>
        @break
        @case(2)
            <div>
                <a href="#!" class="button big-button" wire:click="game_stop">
                    {{ __('ПАУЗА') }}
                </a>
            </div>
            <br/>
            <br/>
            <div>
                <a href="#!" class="button big-button" wire:click="time_exit">
                    {{ __("ЗАВЕРШИТЬ $game->num_periods ТАЙМ") }}
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
            <a href="#!" class="button big-button" wire:click="time_exit">
                {{ __("ЗАВЕРШИТЬ $game->num_periods ТАЙМ") }}
            </a>
        </div>
        @break
        @case(4)
        <div>
            <a href="#!" class="button big-button" wire:click="time_new">
                {{ __("НАЧАТЬ ".($game->num_periods+1)." ТАЙМ") }}
            </a>
        </div>
        <br/>
        <br/>
        <div>
            <a href="#!" class="button big-button" wire:click="game_exit">
                {{ __('ЗАВЕРШИТЬ ИГРУ') }}
            </a>
        </div>
        @break
    @endswitch
</div>
