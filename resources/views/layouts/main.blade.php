{{--
@yield('title') - название страницы
@yield('content') - содержимое страницы
@yield('style') - название стиля страницы
@yield('fa') - подключение стиля font awersome
--}}
<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--Стили макета -->
    <link rel="stylesheet" href="/assets/css/maket_styles.css" />
    <!-- Стиль данной страницы -->
    <link rel="stylesheet" href="/assets/css/@yield('style')" />
    <!-- Стиль всех наших страниц сайта -->
    <link rel="stylesheet" href="/assets/css/global.css" />
    <!--  Подключение стилей для иконок font awersome  -->
    <link rel="stylesheet" href="/assets/css/fontawesome/all.min.css" />

    <link rel="stylesheet" href="/assets/css/app.css" />
    @livewireStyles

    <noscript><link rel="stylesheet" href="/assets/css/noscript.css" /></noscript>
</head>
<body class="landing is-preload">

<!-- Page Wrapper -->
<div id="page-wrapper">

    @include('layouts.navbar')

    @yield('content')

</div>
@include('layouts.footer')
</body>
<!-- Scripts -->
@livewireScripts
<script src="/assets/js/app.js" defer></script>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.scrollex.min.js"></script>
<script src="/assets/js/jquery.scrolly.min.js"></script>
<script src="/assets/js/browser.min.js"></script>
<script src="/assets/js/breakpoints.min.js"></script>
<script src="/assets/js/util.js"></script>
<script src="/assets/js/main.js"></script>

</html>


