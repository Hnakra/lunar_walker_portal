<div class="component">
    <a class="show-modal" wire:click="createShowModal">
        {{ $robot->name }}
    </a>

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            <h2 class="title-modal">{{ __('РОБОТ') }}</h2>

        </x-slot>
        <x-slot name="content">
            <div class="">
                <div class="square round" style="background-image: url('{{$robot->photo}}');"></div>
                <div class="info">
                    <p><span>Название: </span>{{$robot->name}}</p>
                    @isset($user)
                    <p><span>Владелец: </span>{{$user->name}}</p>
                    @endisset()
                    <p><span>Дата регистрации: </span>{{$robot->created_at}}</p>

                    <div class="edit-wrapper">
                        @if(Auth::check() && Auth::user()->isOwnerOrAdmin($robot->id_master))
                            @livewire('remove-robot',['current_robot' => $robot->id])
                            @livewire('forms.robot-form', ['current_robot' => $robot->id])
                        @endif
                    </div>


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
