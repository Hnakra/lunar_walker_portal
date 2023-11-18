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
            {{ __('Последнее обновление'). ': '.$refreshTime }}
            <x-jet-secondary-button class="refresh-button" wire:click="render">
                <i class="fas fa-sync"></i>{{ __('Обновить') }}
            </x-jet-secondary-button>

            <section class="tournament">
                <h5>{{__('Площадка')}}: <a href="/places/{{$tournament->place->id}}"
                                 class="link-name1">{{$tournament->place->name}}</a></h5>
                <h5>{{__('Дата/время проведения')}}:{{$tournament->date_time}}</h5>

                @foreach($groups as $i => $group)
                    <div>
                        <table class="tournament-table">
                            <thead>
                            <tr>
                                @foreach($group['head'] as $k => $item)
                                    <th @if($group['headDescription'][$k] !== "") title="{{$group['headDescription'][$k]}}" @endif>
                                        {{$item}}
                                    </th>
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>


                            @for($j = 0; $j < count($group[0]['games']); $j++)
                                @php
                                    $team = $group[$j];
                                @endphp

                                <tr>
                                    <td title="Номер" class="center-text">{{$team['number']}}</td>
                                    <td>{{$team['teamName']}}</td>
                                    @foreach($team['games'] as $z => $game)
                                        @if($game === 'X')
                                            <td class="x count center-text"></td>
                                        @else
                                            <td class="count center-text" title="{{$team['gameDescription'][$z]}}">
                                                {{$game}}
                                            </td>
                                        @endif
                                    @endforeach

                                    <td class="center-text" title="{{$team['pointsDescription']}}">
                                        {{$team['points']}}
                                    </td>
                                    <td class="center-text" title="{{$team['differentDescription']}}">
                                        {{$team['different']}}</td>
                                    <td title="{{$team['placeDescription']}}">
                                        {{$team['place']}}
                                    </td>
                                </tr>
                            @endfor

                            </tbody>

                        </table>
                    </div>
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
