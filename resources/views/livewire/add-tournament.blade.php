<div>
    <x-jet-button  wire:click="createShowModal">
        {{ __('Добавить турнир') }}
    </x-jet-button>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Добавление турнира') }}
        </x-slot>
        <x-slot name="content">
        <div class="center-text">{{ __('Введите информацию о турнире') }}</div>
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Название') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />
            <select wire:model="id_place">
                <option value ="0" selected>Выберите площадку</option>
                    @foreach($places as $place)
                        <option value="{{$place->id}}">{{$place->name}}</option>
                    @endforeach

            </select>
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Описание') }}"
                         x-ref="name"
                         wire:model.defer="description"
                         wire:keydown.enter="" />

            <input type="date" wire:model.defer="date" "/>
            <input type="time" wire:model.defer="time" "/>
            <div class="text-on-form">{{__('Команды')}}
            <button wire:click.prevent="addTeam" class="fa fa-plus"></button></div>

            @foreach($selected_teams_id as $index => $team_id)
                <select class="child-form" wire:model="selected_teams_id.{{$index}}">
                    <option value ="0" selected>Выберите команду</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endforeach
                </select>
                <button wire:click.prevent="removeTeam({{$index}})" class="fa fa-minus"></button>
            @endforeach
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                {{ __('Добавить турнир') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
