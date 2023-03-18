<div >
    <a href="#!" class="button big-button" wire:click="createShowModal">
        {{ __('СОЗДАТЬ ТУРНИРНУЮ ТАБЛИЦУ ИГР') }}
    </a>
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Добавление турнирной таблицы') }}
        </x-slot>
        <x-slot name="content">
            @error('selectedTable') <span class="error">{{ $message }}</span> @enderror
            <select required wire:model="selectedTable">
                <option value ="" selected>Выберите турнирную таблицу</option>
                @foreach($listTables as $k => $v)
                    <option value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
            <select wire:model="numGroups">
                @for($i=1; $i<=$MAX_NUM_GROUPS; $i++)
                    <option value="{{$i}}">Кол-во групп (разбиений команд) = {{$i}}</option>
                @endfor
            </select>
            @if($numGroups > 1)
                <div class="groupingTypeRadio">
                    <input type="radio" id="groupingTypeAuto" name="groupingType" value="auto" wire:model="groupingType">
                    <label for="groupingTypeAuto">Автоматическая группировка</label>

                    <input type="radio" id="groupingTypeManual" name="groupingType" value="manual" wire:model="groupingType">
                    <label for="groupingTypeManual">Ручная группировка</label>
                    @if($groupingType == "manual")
                        <p>Таблица группировок</p>
                        <table>
                            <tr>
                                <th>Название команды</th>
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
            @if($selectedTable == 'all_vs_all')
                <select wire:model.defer="interval">
                    <option value =600 selected>Время между началами игр: 10 минут</option>
                    <option value =900>Время между началами игр: 15 минут</option>
                </select>
                <select wire:model.defer="max_seconds_match">
                    <option value =300 selected>Длительность тайма: 5 минут</option>
                    <option value =240>Длительность тайма: 4 минуты</option>
                    <option value =180>Длительность тайма: 3 минуты</option>
                </select>
            @endif
        </x-slot>
        <x-slot name="footer">

            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                {{ __('Добавить турнирную таблицу') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
