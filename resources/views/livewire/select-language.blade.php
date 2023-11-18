<span>
    <x-jet-dropdown align="right" width="96">
        <x-slot name="trigger">
            <button class="text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                @if(App::isLocale('ru'))
                    <img class="h-8 w-8 rounded-full object-cover navbar-image" src="/assets/images/ru.png"
                         alt="{{ __('Русский язык') }}"/>
                @endif
                @if(App::isLocale('en'))
                    <img class="h-8 w-8 rounded-full object-cover navbar-image" src="/assets/images/en.png"
                         alt="{{ __('Английский язык') }}"/>
                @endif
            </button>
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Язык сайта') }}
            </div>

            <a class="lang-link" href="#" wire:click="changeLanguage('ru')">
                @if(App::isLocale('ru'))
                    <i class="fas fa-check"></i>
                @endif
                {{ __('Русский язык') }}
            </a>
            <a class="lang-link" href="#" wire:click="changeLanguage('en')">
                @if(App::isLocale('en'))
                    <i class="fas fa-check"></i>
                @endif
                {{ __('Английский язык') }}
            </a>

            <div class="border-t border-gray-100"></div>

        </x-slot>
    </x-jet-dropdown>
</span>
