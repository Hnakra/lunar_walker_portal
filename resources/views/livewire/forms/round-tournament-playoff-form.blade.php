<div class="edit-wrapper">

    @if(!$this->isCompletedPlayoff())

        @if($this->isFinalRoundPlayoff())
            <a href="#!" class="button big-button" wire:click="createShowModal">
                {{ __('СГЕНЕРИРОВАТЬ ФИНАЛ') }}
            </a>
        @else
            <a href="#!" class="button big-button" wire:click="createShowModal">
                {{ __('СГЕНЕРИРОВАТЬ СЛЕДУЮЩИЙ КРУГ') }}
            </a>
        @endif
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{$this->isFinalRoundPlayoff() ? __('Подтверждение генерации финала') :  __('Подтверждение генерации следующего playoff круга')}}
        </x-slot>

        <x-slot name="content">
            {{$this->isFinalRoundPlayoff() ? __('Введите информацию о финале') :  __('Введите информацию о playoff круге')}}
            <input type="date" wire:model.defer="date" required/>
            <input type="time" wire:model.defer="time" required/>
            @error('date') <span class="error">{{ $message }}</span> @enderror
            @error('time') <span class="error">{{ $message }}</span> @enderror

            <select wire:model.defer="interval">
                <option value=600 selected>{{__('Время между началами игр: 10 минут')}}</option>
                <option value=900>{{__('Время между началами игр: 15 минут')}}</option>
            </select>
            <select wire:model.defer="max_seconds_match">
                <option value=300 selected>{{__('Длительность тайма: 5 минут')}}</option>
                <option value=240>{{__('Длительность тайма: 4 минуты')}}</option>
                <option value=180>{{__('Длительность тайма: 3 минуты')}}</option>
            </select>
            <br>
            @error('id_tournament') <span class="error" style="color: orangered">{{ $message }}</span> @enderror
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3 button-main" wire:click="submitShowModal" wire:loading.attr="disabled">
                {{ __('Подтвердить генерацию') }}
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
