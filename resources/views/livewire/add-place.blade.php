<div class="p-6">
    <x-jet-button  wire:click="createShowModal">
        {{ __('Добавить площадку') }}
    </x-jet-button>


    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Добавление площадки') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Введите информацию о площадке.') }}
        </x-slot>
        <x-jet-input type="text"
                     placeholder="{{ __('Пароль') }}"
                     x-ref="password"
                     wire:model.defer="name">

        </x-jet-input>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

    {{--        <x-jet-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('Удаление аккаунта') }}
            </x-jet-danger-button>--}}
        </x-slot>
    </x-jet-dialog-modal>
</div>
