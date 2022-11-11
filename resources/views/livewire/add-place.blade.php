<div class="p-6" >

    @if($current_place == 0)
        <ul class="actions special">
            <li><a wire:click="createShowModal" href="#" class="button big-button">ДОБАВИТЬ ПЛОЩАДКУ</a></li>
        </ul>
    @else
        <ul class="actions special">
            <li><a wire:click="editShowModal" href="#" class="button big-button">ИЗМЕНИТЬ ПЛОЩАДКУ</a></li>
        </ul>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">
        @if($current_place == 0)
                <x-slot name="title">
                    {{ __('Добавление площадки') }}
                </x-slot>
            @else
            <x-slot name="title">
                {{ __('Изменение площадки') }}
            </x-slot>
        @endif
                <x-slot name="content">
                    <div class="center-text"> {{ __('Введите информацию о площадке') }}</div>
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Название') }}"
                                 x-ref="name"
                                 wire:model.defer="name"
                                 wire:keydown.enter="" />
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="email" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Адрес') }}"
                                 x-ref="address"
                                 wire:model.defer="address"
                                 wire:keydown.enter="" />
                    @error('address') <span class="error">{{ $message }}</span> @enderror
                    <select wire:model="id_organizator">
                        <option value ="0" selected>Выберите организатора</option>
                        @foreach($listUsers as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>

                        @endforeach
                    </select></br>
                    @error('id_organizator') <span class="error">{{ $message }}</span> @enderror
{{--                    <x-jet-input type="email" class="mt-1 block w-3/4"
                                 placeholder="{{ __('ID организатора (Пока так)') }}"
                                 x-ref="id_organizator"
                                 wire:model.defer="id_organizator"
                                 wire:keydown.enter="" />--}}
                    <div wire:loading wire:target="photo">Загрузка...</div>
                    <input type="file" wire:model="photo">
                    @error('photo') <span class="error" style="color: orangered">{{ $message }}</span> @enderror

                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Описание площадки') }}"
                                 x-ref="description"
                                 wire:model.defer="description"
                                 wire:keydown.enter="" />
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Адрес организации') }}"
                                 x-ref="addr_org"
                                 wire:model.defer="addr_org"
                                 wire:keydown.enter="" />
                    @error('addr_org') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Наименование юридического лица организатора') }}"
                                 x-ref="name_urid_org"
                                 wire:model.defer="name_urid_org"
                                 wire:keydown.enter="" />
                    @error('name_urid_org') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Сайт площадки') }}"
                                 x-ref="site_urid_org"
                                 wire:model.defer="site_urid_org"
                                 wire:keydown.enter="" />
                    @error('site_urid_org') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Телефон площадки') }}"
                                 x-ref="phone_urid_org"
                                 wire:model.defer="phone_urid_org"
                                 wire:keydown.enter="" />
                    @error('phone_urid_org') <span class="error">{{ $message }}</span> @enderror
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('ИНН организации') }}"
                                 x-ref="INN_urid_org"
                                 wire:model.defer="INN_urid_org"
                                 wire:keydown.enter="" />
                    @error('INN_urid_org') <span class="error">{{ $message }}</span> @enderror
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                        {{ __('Отмена') }}
                    </x-jet-secondary-button>
                    @if($current_place == 0)
                    <x-jet-button class="ml-3 button-main" wire:click="addingPlace" wire:loading.attr="disabled">
                        {{ __('Добавить площадку') }}
                    </x-jet-button>
                    @else
                        <x-jet-button class="ml-3 button-main" wire:click="modifyPlace" wire:loading.attr="disabled">
                            {{ __('Изменить площадку') }}
                        </x-jet-button>
                    @endif
                </x-slot>
    </x-jet-dialog-modal>
</div>
