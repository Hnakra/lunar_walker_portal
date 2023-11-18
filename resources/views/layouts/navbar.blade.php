<!-- Header -->
<header id="header" class="alt">
    <div class="navabar">
        <a href="#menu" class="menuToggle"><i class="fa fa-bars"></i></a>
        <h3><a href="/">{{__('РОБОФУТБОЛ')}}</a></h3>
        <!--
                    Меню мобильной версии
        -->
        <div id="menu">
            <ul>
                @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isOrganizer() || Auth::user()->isTrainer()))
                    <li><a href="/users">{{__('Пользователи')}}</a></li>
                    <li><a href="/robots">{{__('Роботы')}}</a></li>
                @endif
                <li><a href="/places">{{__('Площадки')}}</a></li>
                <li><a href="/teams">{{__('Команды')}}</a></li>
                <li><a href="/games">{{__('Игры')}} </a></li>
                <div class="submenu">
                    <li><a href="/tournaments">{{__('Мои игры')}}</a></li>
                    <li><a href="/statistic">{{__('Статистика')}}</a></li>
                </div>

                <li><a href="/about_us">{{__('О нас')}}</a></li>
            </ul>
        </div>
        <!--
                    Меню компьютерной версии
        -->
        <div class="menu">
            <ul id="navbar">
                @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isOrganizer() || Auth::user()->isTrainer()))
                    <li><a href="/users">{{__('Пользователи')}}</a></li>
                    <li><a href="/robots">{{__('Роботы')}}</a></li>
                @endif
                <li><a href="/places">{{__('Площадки')}}</a></li>
                <li><a href="/teams">{{__('Команды')}}</a></li>

                <li><a href="/games">{{__('Игры')}} <i class="fas fa-angle-down"></i> </a>
                    <div class="submenu-wrapper">
                        <ul>
                            <li><a href="/tournaments">{{__('Мои игры')}}</a></li>
                            <li><a href="/statistic">{{__('Статистика')}}</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="/about_us">{{__('О нас')}}</a></li>
                <li>@livewire('select-language', ['urlRedirect' => Request::url()])</li>
                <li>@include('layouts.user_icon.user_icon_bigscreen')</li>
            </ul>

            <span class="mobile-profile">
                @livewire('select-language', ['urlRedirect' => Request::url()])
                @include('layouts.user_icon.user_icon_bigscreen')
            </span>

        </div>
    </div>
</header>
