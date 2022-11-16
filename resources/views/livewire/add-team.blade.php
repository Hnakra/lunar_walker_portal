<div>

    @if($current_team == 0)
        <a href="#!" wire:click="createShowModal" class="button big-button">ДОБАВИТЬ КОМАНДУ</a>
    @else
        <a href="#!"  wire:click="editShowModal" class="button-edit" title="редактировать команду"><i class="fa fa-edit" style="font-size:30px"></i></a>
    @endif

    <x-jet-dialog-modal wire:model="modalFormVisible">

        @if($current_team == 0)
        <x-slot name="title">
            {{ __('Добавление команды') }}
        </x-slot>
        @else
            <x-slot name="title">
                {{ __('Редактирование команды') }}
            </x-slot>
        @endif

        <x-slot name="content">
            {{ __('Введите информацию о команде') }}
            <x-jet-input type="text" class="mt-1 block w-3/4 " required
                         placeholder="{{ __('Название команды*') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />

            @error('name') <span class="error" style="color: orangered">{{ __('Длина имени не должна быть менее, чем 3 символа!')  }}</span><br> @enderror

            <span>{{__('Игроки')}}</span>
            @if(count($selected_users_id) < $MAX_SELECTED_USERS)
                <button wire:click.prevent="addUser" class="fa fa-plus"></button>
            @endif

            @foreach($selected_users_id as $index => $user_id)
                <select required class="child-form" wire:model="selected_users_id.{{$index}}">
                    <option value ="" selected>Выберите игрока</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <button wire:click.prevent="removeUser({{$index}})" class="fa fa-minus"></button>
            @endforeach
            <span class="error" style="color: orangered">{{ $errorOutput }}</span>
            <br>

        </x-slot>

        <x-slot name="footer">
            <div class="remove-button">
                @if($current_team != 0)
                    @livewire('remove-team',["current_team" => $current_team])
                @endif
            </div>

            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Отмена') }}
            </x-jet-secondary-button>
            @if($current_team == 0)
            <x-jet-button class="ml-3 button-main" wire:click="adding" wire:loading.attr="disabled">
                {{ __('Создать команду') }}
            </x-jet-button>
            @else
                <x-jet-button class="ml-3 button-main" wire:click="modification" wire:loading.attr="disabled">
                    {{ __('Редактировать команду') }}
                </x-jet-button>

            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
