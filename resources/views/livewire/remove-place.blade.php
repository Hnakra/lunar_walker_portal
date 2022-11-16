<div>
    <button class="rm" wire:click="confirmRemove">
        <i class="fas fa-trash" ></i>
    </button>
    <x-jet-dialog-modal wire:model="modalFormVisible" >
        <x-slot name="title">
            {{ __('Удаление площадки') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Подтвердите удаление площадки.') }}
            <div class="error">
                {{$errorMessage}}
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-3 button-main remove" wire:click="remove" wire:loading.attr="disabled">
                {{ __('Удалить площадку') }}
            </x-jet-button>


        </x-slot>
    </x-jet-dialog-modal>
</div>
