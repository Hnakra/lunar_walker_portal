<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>Мои Турниры</h2>
        <p>Подтвердите участие в<br />
            грядущих турнирах</p>
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>
{{--
{{($tournaments[0]['team'])}}
--}}
<section id="one" class="wrapper style5">
    <div class="inner">
        @if(Auth::user()->isUser())
            @include('content.games.tournaments.layouts.content-for-user')
        @endif
        @if(Auth::user()->isAdmin())
            @include('content.games.tournaments.layouts.content-for-admin')
        @endif


    </div>
</section>


