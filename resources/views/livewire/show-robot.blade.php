<div>
    <a href="#!" class="" wire:click="createShowModal">
        <b>{{ $robot->name }}</b>
    </a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            <h2 class="title-modal">{{ __('РОБОТ') }}</h2>

        </x-slot>
        <x-slot name="content">
            <div class="block">
                <div class="square round" style="background-image: url('../storage/robots/{{$robot->id}}/{{$robot->img}}');"></div>
                <div class="info">
                    <p><span>Название: </span>{{$robot->name}}</p>
                    @isset($user)
                    <p><span>Владелец: </span> <a class="user" href="#">{{$user->name}}</a></p>
                    @endisset()
                    <p><span>Дата регистрации: </span>{{$robot->created_at}}</p>

                    @if(Auth::check() && !Auth::user()->isUser())
                        @livewire('add-robot', ['current_robot' => $robot->id])
                    @endif


                </div>
            </div>
            <div class="definition-title">{{ __('ОПИСАНИЕ ') }}</div>
            <div class="definition-text">{{$robot->notation}}</div>
{{--            {{$robot}}--}}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="button-secondary" wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('НАЗАД') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
