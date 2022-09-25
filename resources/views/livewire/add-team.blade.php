<div>

    @if($current_team == 0)
        <x-jet-button  wire:click="createShowModal">
            {{ __('Добавить команду') }}
        </x-jet-button>
    @else
        <x-jet-button  wire:click="editShowModal">
            <i class="fas fa-pen" style="color: white"></i>
        </x-jet-button>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">

        @if($current_team == 0)
        <x-slot name="title">
            {{ __('Добавление команды') }}
        </x-slot>
        @else
            <x-slot name="title">
                {{ __('Редактирование команды') }}
            </x-slot>
        @endif

        <x-slot name="content">
            {{ __('Введите информацию о команде.') }}
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Название команды') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />

            @error('name') <span class="error" style="color: orangered">{{ __('Длина имени не должна быть менее, чем 3 символа!')  }}</span><br> @enderror

            @php
             echo $userForm;
            @endphp
            <span class="error" style="color: orangered">{{ $errorOutput }}</span>
            <br>
            @if($counterUserForms < 5)
                <button class = "plus" wire:click="createUserForm">
                    {{ __('Добавить место в командe') }}
                </button>
            @endif
            @if($counterUserForms != 0)
                <button class = "minus" wire:click="removeUserForm">
                    {{ __('Убрать место из команды') }}
                </button>
            @endif

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>
            @if($current_team == 0)
            <x-jet-button class="ml-3" wire:click="adding" wire:loading.attr="disabled">
                {{ __('Создать команду') }}
            </x-jet-button>
            @else
                <x-jet-button class="ml-3" wire:click="modification" wire:loading.attr="disabled">
                    {{ __('Редактировать команду') }}
                </x-jet-button>
                @if($current_team != 0)
                    @livewire('remove-team',["id_place" => $id_place, "current_team" => $current_team])
                @endif
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
