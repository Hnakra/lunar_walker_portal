<div class="p-6">
    <x-jet-button  wire:click="createShowModal">
        {{ __('Добавить своего робота') }}
    </x-jet-button>
    <x-jet-dialog-modal wire:model="modalFormVisible">

        <x-slot name="title">
            {{ __('Добавление робота') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Введите информацию о роботе.') }}
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Имя робота') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Уникальный ключ робота') }}"
                         x-ref="key"
                         wire:model.defer="key"
                         wire:keydown.enter="" />

            <div wire:loading wire:target="photo">Uploading...</div>
            <input type="file" wire:model="photo">
            @error('photo') <span class="error" style="color: orangered">{{ $message }}</span> @enderror
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Прочее') }}"
                         x-ref="notation"
                         wire:model.defer="notation"
                         wire:keydown.enter="" />

        </x-slot>



        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="addingRobot" wire:loading.attr="disabled">
                {{ __('Добавить робота') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
