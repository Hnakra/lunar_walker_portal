<div>
    <a href="#!" class="button big-button" wire:click="createShowModal">
        {{ __('СОЗДАТЬ ИГРУ') }}
    </a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Добавление игры') }}
        </x-slot>
        <x-slot name="content">
            <input type="date" wire:model.defer="date"/>
            <input type="time" wire:model.defer="time"/>
            <select wire:model.defer="id_team_1">
                <option value ="0" selected>1 команда</option>
                @foreach($teams as $team)
                    <option value="{{$team->id_team}}">{{$team->name}}</option>
                @endforeach
            </select>
            <select wire:model.defer="id_team_2">
                <option value ="0" selected>2 команда</option>
                @foreach($teams as $team)
                    <option value="{{$team->id_team}}">{{$team->name}}</option>
                @endforeach
            </select>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                {{ __('Добавить игру') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
