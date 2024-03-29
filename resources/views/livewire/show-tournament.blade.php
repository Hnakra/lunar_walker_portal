<div class="component">
    <a wire:click="createShowModal" class="show-modal">{{$tournament->name}}</a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{$tournament->name}}
        </x-slot>
        <x-slot name="content">
            <br>
            @if($isExistsAlternativeVisible)
                <x-jet-secondary-button class="button-swap tapped" wire:click="$set('alternativeVisible', false)">
                    {{ __('Строчное представление') }}
                </x-jet-secondary-button>
                <x-jet-secondary-button class="button-swap" wire:click="$set('alternativeVisible', true)">
                    {{ __('Табличное представление') }}
                </x-jet-secondary-button>
            @endif
            <br>
            {{ __('Последнее обновление').': '.$refreshTime }}
            <x-jet-secondary-button class="refresh-button" wire:click="render">
                  <i class="fas fa-sync"></i>{{ __('Обновить') }}
            </x-jet-secondary-button>

            <section class="tournament">
                <h5>{{__('Площадка')}}: <a href="/places/{{$tournament->place->id}}" class="link-name1" >{{$tournament->place->name}}</a></h5>
                <h5>{{__('Дата/время проведения')}}:{{$tournament->date_time}}</h5>

                <div class="table-wrapper">
                    <table>
                        <thead>
                        <tr>
                            @if($tournament->isGrouped())
                                <th>{{__('Группа')}}</th>
                            @endif
                            <th>{{__('Время')}}</th>
                            <th>{{__('Команды')}}</th>
                            <th>{{__('Счет')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournament->games as $game)
                            <tr>
                                @if($tournament->isGrouped())
                                    <td>{{$game->groupName()}}</td>
                                @endif
                                <td>{{$game->getTime()}}</td>
                                <td>{{$game->team_1->name}} VS {{$game->team_2->name}}</td>
                                <td>{{$game->count_team_1}}:{{$game->count_team_2}}</td>
                                <td><a href="/game/{{$game->id}}" title="{{__('информация об игре')}}" class="points">...</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </section>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
