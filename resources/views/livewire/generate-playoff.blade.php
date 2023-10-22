<div>
    <a href="#!" class="button big-button" wire:click="createShowModal">
        {{ __('СГЕНЕРИРОВАТЬ PLAYOFF') }}
    </a>
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __("Генерация PLAYOFF'a турнира") }}
        </x-slot>
        <x-slot name="content">
            <div class="center-text">{{ __('Введите информацию о турнире') }}</div>
            <x-jet-input type="text" required class="mt-1 block w-3/4"
                         placeholder="{{ __('Название') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter=""/>
            @error('name') <span class="error">{{ $message }}</span> @enderror

            <x-jet-input type="text" class="mt-1 block w-3/4"
                         placeholder="{{ __('Описание') }}"
                         x-ref="name"
                         wire:model.defer="description"
                         wire:keydown.enter=""/>

            <input type="date" wire:model.defer="date" required/>
            <input type="time" wire:model.defer="time" required/>
            @error('date') <span class="error">{{ $message }}</span> @enderror
            @error('time') <span class="error">{{ $message }}</span> @enderror
            <br>
            @isset($teams)
                @foreach($teams as $k => $data)
                    <div>
                        <input @if($data['isChecked']) checked @endif type="checkbox" id="checkbox-{{$k}}"
                            wire:change="update_checkbox('{{$k}}')">
                        <label for="checkbox-{{$k}}">{{$data['team']}}</label>
                    </div>
                @endforeach
            @endisset
            @error('teams') <span class="error">{{ $message }}</span> @enderror


            <x-slot name="footer">

                <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')"
                                        wire:loading.attr="disabled">
                    {{ __('Отмена') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                    {{ __('Генерация') }}
                </x-jet-button>

            </x-slot>
        </x-slot>
    </x-jet-dialog-modal>
</div>
