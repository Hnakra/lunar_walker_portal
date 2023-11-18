<div class="component">
    <a wire:click="createShowModal" class="show-modal">{{$user->name}}</a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            @isset($user->initials)
            @foreach ($user->initials as $initial)
                <div class="title-modal-user">{{$initial}}</div>
            @endforeach
            @endisset

        </x-slot>
        <x-slot name="content">
            <div class="block-show-user">
{{--                <div class="square round" style="background-image: url('../storage/users/{{$user->id}}/{{$user->img}}');"></div>--}}
                <div class="round-image" style="background-image: url('{{$user->photo}}')"></div>
                <div class="info">
{{--                    <p><span>Имя пользователя: </span>{{$user->name}}</p>--}}
                    <p><span>{{__('Дата регистрации')}}: </span>{{$user->created_at}}</p>
                    @isset($teams)
                        <p><span>{{__('Команды')}}: </span><br/>
                        @foreach($teams as $team)
                        "{{$team->name}}" <br/>
                        @endforeach
                        </p>
                    @endisset
                    @isset($robots)
                        <p><span>{{__('Роботы')}}: </span><br/>
                            @foreach($robots as $robot)
                                {{$robot->name}} <br/>
                            @endforeach
                        </p>
                    @endisset()
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
