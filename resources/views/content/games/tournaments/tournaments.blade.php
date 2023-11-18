<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>Мои Турниры</h2>
        @if(Auth::user()->isAdmin()||Auth::user()->isOrganizer()||Auth::user()->isTrainer())
            <p>{{__('Ознакомьтесь, кто подтвердил участие в турнирах')}}</p>
        @else
            <p>{{__('Подтвердите участие в грядущих турнирах')}}</p>
        @endif{{__('')}}

    </div>
    <a href="#one" class="more scrolly">{{__('Читать далее')}}</a>
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


