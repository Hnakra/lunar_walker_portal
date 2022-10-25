<x-guest-layout>
    <div class="background-login">
        <x-jet-authentication-card>

            <x-slot name="logo">

            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                <div class="title">Вход<br> <br> </div>
                @csrf

                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <input id="email"  type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Пароль') }}" />
                    <input id="password"  type="password" name="password" required autocomplete="current-password" />

                </div>

                <div class="remember_me mt-4">
                    <input type="checkbox" id="remember_me" name="remember" />
                    <label for="remember_me" class="">
                        <span class="ml-2 text-gray-600 remember_me_span">{{ __('Запомнить меня') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 link" href="{{ route('password.request') }}">
                            {{ __('Забыли пароль?') }}
                        </a>
                    @endif

                    <x-jet-button class="button button-main">
                        {{ __('Войти') }}
                    </x-jet-button>
                </div>
            </form>
            <div align="center"> <br>Ещё нет аккаунта? <br><a class="underline text-sm text-gray-600 hover:text-gray-900" href = "../register">Зарегистрируйтесь</a></div>
        </x-jet-authentication-card>
    </div>

</x-guest-layout>
