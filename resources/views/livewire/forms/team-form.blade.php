<div class="edit-wrapper">

    @if($current_team == 0)
        <a href="#!" wire:click="createShowModal" class="button big-button">{{__('ДОБАВИТЬ КОМАНДУ')}}</a>
    @else
        <a href="#!"  wire:click="editShowModal" class="button-edit" title="{{__('редактировать команду')}}"><i class="fa fa-edit" style="font-size:30px"></i></a>
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
                         placeholder="{{ __('Название команды') }}"
                         x-ref="name"
                         wire:model.defer="name"
                         wire:keydown.enter="" />

            @error('name') <span class="error" style="color: orangered">{{ __('Длина имени не должна быть менее, чем 3 символа!')  }}</span><br> @enderror
            @if(Auth::user()->isAdmin())
            <span>{{__('Тренер')}}</span>
            <select class="child-form" wire:model="selected_trainer">
                <option value ="0">{{__('Нет тренера')}}</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
            @endif

            <span>{{__('Игроки')}}</span>
            @if(count($selected_users_id) < $MAX_SELECTED_USERS)
                <button wire:click.prevent="addUser" class="fa fa-plus"></button>
            @endif

            @foreach($selected_users_id as $index => $user_id)
                <select required class="child-form" wire:model="selected_users_id.{{$index}}">
                    <option value ="" selected>{{__('Выберите игрока')}}</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <button wire:click.prevent="removeUser({{$index}})" class="fa fa-minus"></button>
            @endforeach
            @error('selected_users_id.*') <span class="error">{{ $message }}</span> @enderror

            <br>

        </x-slot>

        <x-slot name="footer">

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
