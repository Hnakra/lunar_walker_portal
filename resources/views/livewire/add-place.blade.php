<div class="p-6" >
    <x-jet-button  wire:click="createShowModal">
        {{ __('Добавить площадку') }}
    </x-jet-button>


    <x-jet-dialog-modal wire:model="modalFormVisible">
{{--        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Удаление аккаунта') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Навсегда удалить свой аккаунт.') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600">
                    {{ __('После удаления вашей учетной записи все ее ресурсы и данные будут безвозвратно удалены. Перед удалением своей учетной записи загрузите любые данные или информацию, которые вы хотите сохранить.') }}
                </div>

                <div class="mt-5">
                    <x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                        {{ __('Удаление аккаунта') }}
                    </x-jet-danger-button>
                </div>

                <!-- Delete User Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingUserDeletion">
                    <x-slot name="title">
                        {{ __('Удаление аккаунта') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Вы уверены, что хотите удалить свой аккаунт? После удаления вашей учетной записи все ее ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.') }}

                        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                            <x-jet-input type="password" class="mt-1 block w-3/4"
                                         placeholder="{{ __('Пароль') }}"
                                         x-ref="password"
                                         wire:model.defer="password"
                                         wire:keydown.enter="deleteUser" />

                            <x-jet-input-error for="password" class="mt-2" />
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                            {{ __('Отмена') }}
                        </x-jet-secondary-button>

                        <x-jet-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                            {{ __('Удаление аккаунта') }}
                        </x-jet-danger-button>
                    </x-slot>
                </x-jet-dialog-modal>
            </x-slot>
        </x-jet-action-section>--}}

                <x-slot name="title">
                    {{ __('Добавление площадки') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Введите информацию о площадке.') }}
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Название') }}"
                                 x-ref="name"
                                 wire:model.defer="name"
                                 wire:keydown.enter="" />
                    <x-jet-input type="email" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Адрес') }}"
                                 x-ref="address"
                                 wire:model.defer="address"
                                 wire:keydown.enter="" />
                    <select wire:model="id_organizator">
                        @php
                        echo implode($listUsers);
                        @endphp
                    </select></br>
{{--                    <x-jet-input type="email" class="mt-1 block w-3/4"
                                 placeholder="{{ __('ID организатора (Пока так)') }}"
                                 x-ref="id_organizator"
                                 wire:model.defer="id_organizator"
                                 wire:keydown.enter="" />--}}
                    <div wire:loading wire:target="photo">Uploading...</div>
                    <input type="file" wire:model="photo">
                    @error('photo') <span class="error" style="color: orangered">{{ $message }}</span> @enderror

                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Адрес организации') }}"
                                 x-ref="addr_org"
                                 wire:model.defer="addr_org"
                                 wire:keydown.enter="" />
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Наименование юридического лица организатора') }}"
                                 x-ref="name_urid_org"
                                 wire:model.defer="name_urid_org"
                                 wire:keydown.enter="" />
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Сайт площадки') }}"
                                 x-ref="site_urid_org"
                                 wire:model.defer="site_urid_org"
                                 wire:keydown.enter="" />
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Телефон площадки') }}"
                                 x-ref="phone_urid_org"
                                 wire:model.defer="phone_urid_org"
                                 wire:keydown.enter="" />
                    <x-jet-input type="text" class="mt-1 block w-3/4"
                                 placeholder="{{ __('ИНН организации') }}"
                                 x-ref="INN_urid_org"
                                 wire:model.defer="INN_urid_org"
                                 wire:keydown.enter="" />
                </x-slot>



                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                        {{ __('Отмена') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-3" wire:click="addingPlace" wire:loading.attr="disabled">
                        {{ __('Добавить площадку') }}
                    </x-jet-button>
                </x-slot>
    </x-jet-dialog-modal>
</div>
