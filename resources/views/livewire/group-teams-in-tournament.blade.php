<div>
    <a href="#!" class="button big-button" wire:click="createShowModal">
        {{ __('СГРУППИРОВАТЬ КОМАНДЫ') }}
    </a>
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Группировка команд') }}
        </x-slot>
        <x-slot name="content">

            <select wire:model="numGroups">
                @for($i=1; $i<=$MAX_NUM_GROUPS; $i++)
                    <option value="{{$i}}">{{__('Кол-во групп (разбиений команд)')}} = {{$i}}</option>
                @endfor
            </select>

            @if($numGroups > 1)
                <div class="groupingTypeRadio">
                    <input type="radio" id="groupingTypeAuto" name="groupingType" value="auto" wire:model="groupingType">
                    <label for="groupingTypeAuto">{{__('Автоматическая группировка')}}</label>

                    <input type="radio" id="groupingTypeManual" name="groupingType" value="manual" wire:model="groupingType">
                    <label for="groupingTypeManual">{{__('Ручная группировка')}}</label>
                    @if($groupingType == "manual")
                        <p>{{__('Таблица группировок')}}</p>
                        <table>
                            <tr>
                                <th>{{__('Название команды')}}</th>
                                @for($i=1; $i<=$numGroups; $i++)
                                    <th>{{range('A', 'Z')[$i-1]}}</th>
                                @endfor
                            </tr>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>
                                        {{$team->name}}
                                    </td>
                                    @for($i=1; $i<=$numGroups; $i++)
                                        <td>
                                            <input type="radio" id="grouping-{{$team->id_team}}-{{$i}}" name="grouping-{{$team->id_team}}" value="{{$i}}" wire:model="teamGroup.{{$team->id_team}}">
                                            <label for="grouping-{{$team->id_team}}-{{$i}}"></label>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @error('teamGroup') <span class="error">{{$message}}</span> @enderror
                        @error('teamGroup.*') <span class="error">{{$message}}</span> @enderror

                    @endif
                </div>

            @endif

            <x-slot name="footer">

                <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Отмена') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                    {{ __('Группировать команды') }}
                </x-jet-button>

            </x-slot>
        </x-slot>
    </x-jet-dialog-modal>
</div>
