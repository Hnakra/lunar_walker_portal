<div>
    <a wire:click="createShowModal" href = "#!"><b>{{$user->name}}</b></a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            <h2 class="title-modal">{{ __('ПОЛЬЗОВАТЕЛЬ') }}</h2>

        </x-slot>
        <x-slot name="content">
            <div class="block">
{{--                <div class="square round" style="background-image: url('../storage/users/{{$user->id}}/{{$user->img}}');"></div>--}}
                <div class="round-image" style="background-image: url('{{$user->photo}}')"></div>
                <div class="info">
                    <p><span>Имя пользователя: </span>{{$user->name}}</p>
                    <p><span>Дата регистрации: </span>{{$user->created_at}}</p>
                    @isset($team)
                        <p><span>Команды: </span>{{$team->name}}</p>
                    @endisset
                    @isset($robot)
                        <p><span>Роботы: </span>{{$robot->name}}</p>
                        <p><small><span>Дата регистрации: </span>{{$robot->created_at}}</small></p>
                    @endisset()
                </div>
            </div>
{{--            <div class="definition-title">{{ __('Роботы') }}</div>--}}
{{--            <div class="definition-text">{{$robot->notation}}</div>--}}
{{--                       {{$user}}--}}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>