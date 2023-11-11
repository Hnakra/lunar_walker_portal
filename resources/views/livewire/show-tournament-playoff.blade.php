<div class="component">
    <a wire:click="createShowModal" class="show-modal">{{$tournament->name}}</a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{$tournament->name}}
        </x-slot>
        <x-slot name="content">
            <br>

            @if($isExistsAlternativeVisible)
                <x-jet-secondary-button class="button-swap" wire:click="$set('alternativeVisible', false)">
                    {{ __('Строчное представление') }}
                </x-jet-secondary-button>
                <x-jet-secondary-button class="button-swap tapped" wire:click="$set('alternativeVisible', true)">
                    {{ __('Табличное представление') }}
                </x-jet-secondary-button>
            @endif
            <br>
            {{ __('Последнее обновление: '.$refreshTime) }}
            <x-jet-secondary-button class="refresh-button" wire:click="render">
                <i class="fas fa-sync"></i>{{ __('Обновить') }}
            </x-jet-secondary-button>

            <section class="tournament">
                <h5>Площадка: <a href="/places/{{$tournament->place->id}}"
                                 class="link-name1">{{$tournament->place->name}}</a></h5>
                <h5>Дата/время проведения:{{$tournament->date_time}}</h5>

            @foreach($rounds as $round)
                    <hr>
                    <p>{{$round['name']}}</p>
                    @foreach($round['games'] as $game)
                        <table class="tournament-table tournament-playoff">
                            <thead>
                            <tr>
                                <th>Команда</th>
                                <th>Счет</th>
                                <th>Результат</th>
                            </tr>
                            </thead>
                            <tr id="show-playoff-team-{{$game['team1']['id']}}"
                                @switch($game['team1']['place'])
                                @case('Победа')
                                style="background-color: #b3ffb3 !important;"
                                @break
                                @case('1 место')
                                style="background-color: #14ff14 !important;"
                                @break
                                @case('2 место')
                                style="background-color: #5cff5c !important;"
                                @break
                                @case('3 место')
                                style="background-color: #8eff8e !important;"
                                @break
                                @endswitch
                            >
                                <td>
                                    {{$game['team1']['name']}}
                                </td>
                                <td>
                                    {{$game['team1']['count']}}
                                </td>
                                <td>
                                    {{$game['team1']['place']}}
                                </td>
                            </tr>
                            <tr id="show-playoff-team-{{$game['team2']['id']}}"
                                @switch($game['team2']['place'])
                                @case('Победа')
                                style="background-color: #b3ffb3 !important;"
                                @break
                                @case('1 место')
                                style="background-color: #14ff14 !important;"
                                @break
                                @case('2 место')
                                style="background-color: #5cff5c !important;"
                                @break
                                @case('3 место')
                                style="background-color: #8eff8e !important;"
                                @break
                                @endswitch
                            >
                                <td>
                                    {{$game['team2']['name']}}
                                </td>
                                <td>
                                    {{$game['team2']['count']}}
                                </td>
                                <td>
                                    {{$game['team2']['place']}}
                                </td>
                            </tr>
                        </table>
                    @endforeach
                    <br>
                    <br>
                @endforeach

            </section>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
