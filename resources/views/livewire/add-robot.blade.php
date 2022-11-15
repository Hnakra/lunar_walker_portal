<div class="p-6">
    @if($current_robot == 0)
    <a href="#!" class="button big-button"  wire:click="createShowModal">
        {{ __('ДОБАВИТЬ РОБОТА') }}
    </a>
    @else
    <button class="btn-edit"><i class="fa fa-edit" wire:click="editShowModal"></i></button>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">

        @if($current_robot == 0)
        <x-slot name="title">
            {{ __('Добавление робота') }}
        </x-slot>
        @else
            <x-slot name="title">
                {{ __('Изменение робота') }}
            </x-slot>
        @endif

        <x-slot name="content">
            {{ __('Введите информацию о роботе.') }}
            <x-jet-input type="text" class="mt-1 block w-3/4" required
                         placeholder="{{ __('Имя робота') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />
            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Уникальный ключ робота') }}"
                         x-ref="key"
                         wire:model.defer="key"
                         wire:keydown.enter="" />

            <label class="input-file">
                <div class = "wait-load-file" wire:loading wire:target="photo">Uploading...</div>
                <div>
                    <input type="file" name="file" wire:model="photo">
                    <span class="button big-button input-file-btn">Выберите фото</span>
                    <span class="input-file-text" type="text">
                        @if(isset($photo))
                            {{$photo->getClientOriginalName()}}
                        @else
                            <span class="error">Название фото</span>
                        @endif
                    </span>
                </div>
            </label>
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

            @if($current_robot == 0)
                <x-jet-button class="ml-3 button-main" wire:click="addingRobot" wire:loading.attr="disabled">
                {{ __('Добавить робота') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-3 button-main" wire:click="modifyShowModal" wire:loading.attr="disabled">
                {{ __('Изменить робота') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
