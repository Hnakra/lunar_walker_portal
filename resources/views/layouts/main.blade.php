{{--
@yield('title') - название страницы
@yield('content') - содержимое страницы
@yield('style') - название стиля страницы
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="font-size: 16px;">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/nicepage.css" media="screen">
    <link rel="stylesheet" href="/css/@yield('style')" media="screen">
    <link rel="stylesheet" href="/css/@yield('fa')" media="screen">
    <script class="u-script" type="text/javascript" src="/js/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="/js/nicepage.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    <script src="{{ mix('js/app.js') }}" defer></script>



    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#f41818">
    <meta property="og:title" content="О нас">
    <meta property="og:type" content="website">
</head>


<body {{--data-home-page="О-нас.html"--}} data-home-page-title="@yield('title')" class="u-body">
@include('layouts.navbar')

@yield('content')

@include('layouts.footer')
@livewireScripts
</body>
</html>
