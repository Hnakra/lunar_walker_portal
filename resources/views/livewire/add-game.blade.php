<div>
    <a href="#!" class="button big-button" wire:click="createShowModal">
        {{ __('СОЗДАТЬ ИГРУ') }}
    </a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Добавление игры') }}
        </x-slot>
        <x-slot name="content">
             {{print_r($id_tournament)}}
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
