<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm">
            {{ __('Забыли пароль? Нет проблем!') }}
        </div>
        <div class="mb-4 text-sm">
            {{ __('Сообщите нам Ваш email. Мы вышлем на него ссылку для сброса пароля. После этого можно будет выбрать новый пароль.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <br>

            <div class=" flex items-center justify-end mt-4">
                <x-jet-button class=" button big-button">
                    {{ __('Отправить ссылку на email') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
