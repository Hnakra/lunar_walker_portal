<div class="remove-button">
    <div class="delete-wrapper">
        <a href="#!" wire:click="confirmRemove" class="button-delete" title="удалить игру">
            <i class="fas fa-trash-alt" style="font-size:30px"></i>
        </a>
    </div>

    <x-jet-dialog-modal wire:model="modalFormVisible" >
        <x-slot name="title">
            {{ __('Удаление робота') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Подтвердите удаление робота.') }}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                св        {{ __('Отмена') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-3 button-main remove" wire:click="remove" wire:loading.attr="disabled">
                {{ __('Удалить робота') }}
            </x-jet-button>


        </x-slot>
    </x-jet-dialog-modal>
</div>
