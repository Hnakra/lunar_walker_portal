<div>

    @if($current_tournament = 0)
        <a  href="##" class="button big-button" wire:click="createShowModal">
            {{ __('СОЗДАТЬ ТУРНИР') }}
        </a>
    @else
        <div class="edit-wrapper">
            <a href="#"  class="button-edit" title="редактировать турнир"><i class="fa fa-edit" style="font-size:30px"></i></a>
        </div>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">
        @if($current_tournament = 0)
        <x-slot name="title">
            {{ __('Добавление турнира') }}
        </x-slot>
        @else
            <x-slot name="title">
                {{ __('Редактирование турнира') }}
            </x-slot>
        @endif

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

            <input type="date" wire:model.defer="date"/>
            <input type="time" wire:model.defer="time"/>
            @error('date') <span class="error">{{ $message }}</span> @enderror
            @error('time') <span class="error">{{ $message }}</span> @enderror
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
            @error('selected_teams_id.*') <span class="error">{{ $message }}</span> @enderror
            @error('users.*') <span class="error">{{ $message }}</span> @enderror


        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            @if($current_tournament = 0)
            <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                {{ __('Добавить турнир') }}
            </x-jet-button>
            @else
                <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                    {{ __('Редактировать турнир') }}
                </x-jet-button>м
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
