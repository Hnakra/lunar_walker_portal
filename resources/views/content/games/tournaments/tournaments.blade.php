<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>Мои Турниры</h2>
        @if(Auth::user()->isAdmin()||Auth::user()->isOrganizer()||Auth::user()->isTrainer())
            <p>Ознакомьтесь, кто подтвердил<br /> участие в турнирах</p>
        @else
            <p>Подтвердите участие в<br />
                грядущих турнирах</p>
        @endif

    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>
{{--
{{($tournaments[0]['team'])}}
--}}
<section id="one" class="wrapper style5">
    <div class="inner">

        @if(Auth::user()->isAdmin()||Auth::user()->isOrganizer()||Auth::user()->isTrainer())
            @include('content.games.tournaments.layouts.content-for-admin')
        @else
            @include('content.games.tournaments.layouts.content-for-user')
        @endif


    </div>
</section>


