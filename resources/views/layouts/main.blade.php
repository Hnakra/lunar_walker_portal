{{--
@yield('title') - название страницы
@yield('content') - содержимое страницы
@yield('style') - название стиля страницы
@yield('fa') - подключение стиля font awersome
--}}
<!DOCTYPE HTML>
<html>
<head>
    {{--счетчики--}}
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CH57RP111G"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-CH57RP111G');
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(91153558, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/91153558" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->


    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--Стили макета -->
    <link rel="stylesheet" href="/assets/css/maket_styles.css" />
    <!-- Стиль данной страницы -->
    <link rel="stylesheet" href="/assets/css/@yield('style')" />
    @hasSection('additional_style_1')
            <link rel="stylesheet" href="/assets/css/@yield('additional_style_1')" />
    @endif
    @hasSection('additional_style_2')
        <link rel="stylesheet" href="/assets/css/@yield('additional_style_2')" />
    @endif
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


