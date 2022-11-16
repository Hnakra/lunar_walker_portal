<div>
    @if($current_game == 0)
        <a href="#!" class="button big-button" wire:click="createShowModal">
            {{ __('СОЗДАТЬ ИГРУ') }}
        </a>
    @else

        <div class="block-icon">
            <button class="btn"><i class="fa fa-edit" style="font-size:30px" wire:click="editShowModal"></i></button>
        </div>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">
        @if($current_game == 0)
        <x-slot name="title">
            {{ __('Добавление игры') }}
        </x-slot>
        @else
            <x-slot name="title">
                {{ __('Редактирование игры') }}
            </x-slot>
        @endif
        <x-slot name="content">
            <input type="date" wire:model.defer="date" required/>
            <input type="time" wire:model.defer="time" required/>
            @error('date') <span class="error">{{ $message }}</span> @enderror
            @error('time') <span class="error">{{ $message }}</span> @enderror

            <select required wire:model.defer="id_team_1">
                <option value ="" selected>1 команда</option>
                @foreach($teams as $team)
                    <option value="{{$team->id_team}}">{{$team->name}}</option>
                @endforeach
            </select>
            @error('id_team_1') <span class="error">{{ $message }}</span> @enderror
            <select required wire:model.defer="id_team_2">
                <option value ="" selected>2 команда</option>
                @foreach($teams as $team)
                    <option value="{{$team->id_team}}">{{$team->name}}</option>
                @endforeach
            </select>
            @error('id_team_2') <span class="error">{{ $message }}</span> @enderror
        </x-slot>
        <x-slot name="footer">

            <div class="remove-button">
                @if($current_game != 0)
                    @livewire('remove-game',["current_game" => $current_game])
                @endif
            </div>


            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            @if($current_game == 0)
                <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                    {{ __('Добавить игру') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-3 button-main" wire:click="modifyShowModal" wire:loading.attr="disabled">
                    {{ __('Редактировать игру') }}
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>
</div>
