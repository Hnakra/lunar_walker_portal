
<div style="text-align: left !important;">
    <button class="remove-team" wire:click="confirmRemove">
        <i class="fas fa-trash" style="color: red"></i>
    </button>

    <x-jet-dialog-modal wire:model="modalFormVisible" >
        <x-slot name="title">
            {{ __('Удаление команды') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Подтвердите удаление команды.') }}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <button class="remove-team " wire:click="remove" wire:loading.attr="disabled">
                {{ __('Удалить команду') }}
            </button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
