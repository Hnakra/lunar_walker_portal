<span>
    <x-jet-dropdown align="right" width="96">
        <x-slot name="trigger">
            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                <img class="h-8 w-8 rounded-full object-cover" src="/assets/images/ru.png" alt="{{ __('Русский язык') }}" />
            </button>
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Язык сайта') }}
            </div>

            <a class="lang-link" href="#" wire:click="changeLanguage('ru')">
                <i class="fas fa-check"></i>{{ __('Русский язык') }}
            </a>
            <a class="lang-link" href="#" wire:click="changeLanguage('en')">
                {{ __('Английский язык') }}
            </a>


            <div class="border-t border-gray-100"></div>


        </x-slot>
    </x-jet-dropdown>
</span>
