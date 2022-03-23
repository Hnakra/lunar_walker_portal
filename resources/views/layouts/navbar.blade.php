<header class="u-clearfix u-header u-palette-3-base u-sticky u-sticky-3e5c u-header" id="sec-0c7a"><div class="u-clearfix u-sheet u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <nav class="u-menu u-menu-dropdown u-offcanvas u-menu-1" data-responsive-from="XS">
            <div class="menu-collapse" style="font-size: 1.25rem; letter-spacing: 0px; font-weight: 500;">
                <a class="u-button-style u-custom-active-color u-custom-border u-custom-border-color u-custom-hover-color u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-text-active-color u-custom-text-color u-custom-text-hover-color u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#" style="padding: 4px; font-size: calc(1em + 8px);">
                    <svg viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><symbol id="menu-hamburger" viewBox="0 0 16 16" style="width: 16px; height: 16px;"><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
                            </symbol>
                        </defs></svg>
                </a>
            </div>
            <div class="u-custom-menu u-nav-container">
                <ul class="u-nav u-spacing-2 u-unstyled u-nav-1">
                    <li class="u-nav-item"><a class="u-active-palette-3-base u-button-style u-hover-palette-3-base u-nav-link u-text-active-grey-5 u-text-grey-90 u-text-hover-white" href="../" style="padding: 10px 6px;">О нас</a>
                    </li>
                    <li class="u-nav-item"><a class="u-active-palette-3-base u-button-style u-hover-palette-3-base u-nav-link u-text-active-grey-5 u-text-grey-90 u-text-hover-white" href="../places" style="padding: 10px 6px;">Площадки</a>
                    </li>
                    <li class="u-nav-item">
                        @include('layouts.user_icon.user_icon_bigscreen')
                    </li>
{{--                    {{Auth::user()->name}}--}}
                </ul>
            </div>
            <div class="u-custom-menu u-nav-container-collapse">
                <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
                    <div class="u-inner-container-layout u-sidenav-overflow">
                        <div class="u-menu-close"></div>
                        <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" style="padding: 10px 20px;">О нас</a>
                            </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="../places" style="padding: 10px 20px;">Площадки</a></li>



                            {{--
                                                        <li class="u-nav-item"><a class="u-button-style u-nav-link" href="../profile" style="padding: 10px 20px;">Профиль</a></li>
                            --}}


                        </ul>


                    </div>
                </div>
                <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
            </div>
        </nav>
        <h3 class="u-headline u-text u-text-default-lg u-text-default-md u-text-default-xl u-text-1">
            <a href="/">РОБОФУТБОЛ!</a>
        </h3>
    </div></header>
