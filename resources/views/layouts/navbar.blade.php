<!-- Header -->
<header id="header" class="alt">
    <div class = "navabar">
        <a href="#menu" class="menuToggle"><i class="fa fa-bars"></i></a>
        <h3><a href="/">РОБОФУТБОЛ</a></h3>
        <!--
                    Меню мобильной версии
        -->
        <div id="menu">
            <ul>
                <li><a href="/users">Пользователи</a></li>
                <li><a href="/robots">Роботы</a></li>
                <li><a href="/places">Площадки</a></li>
                <li><a href="/teams">Команды</a></li>
                <li><a href="/games">Игры </a> </li>
                <div class = "submenu">
                    <li><a href="/tournaments">Мои игры</a></li>
                    <li><a href="/statistic">Статистика</a></li>
                </div>

                <li><a href="/about_us">О нас</a></li>
            </ul>
        </div>
        <!--
                    Меню компьютерной версии
        -->
        <div class="menu">
                    <ul id="navbar">
                        <li><a href="/users">Пользователи</a></li>
                        <li><a href="/robots">Роботы</a></li>
                        <li><a href="/places">Площадки</a></li>
                        <li><a href="/teams">Команды</a></li>

                        <li><a href="/games">Игры <i class="fas fa-angle-down"></i> </a>
                            <div class="submenu-wrapper">
                                <ul>
                                    <li><a href="/tournaments">Мои игры</a></li>
                                    <li><a href="/statistic">Статистика</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="/about_us">О нас</a></li>
                        <li>@include('layouts.user_icon.user_icon_bigscreen')</li>
                    </ul>
            <div class="mobile-profile">@include('layouts.user_icon.user_icon_bigscreen')</div>


        </div>
    </div>
</header>
