<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ПОЛЬЗОВАТЕЛИ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

{{--<h1 style="padding-top: 100px">@yield('title')</h1>--}}
<section class="cards wrapper style5" id = "one">
    @foreach($users as $user)
        <div class="card">

            <div class="round-image" style="background-image: url('{{$user->photo}}')"></div>
            @livewire('show-user', ['user' => $user])

            @if($user->teams->count() == 1)
                <p><small>Команда "{{$user->teams->first()->name}}"</small></p>
            @endif
            @if($user->teams->count() >= 2)
                <p><small>Команды
                        @foreach($user->teams as $team)
                            "{{$team->name}}"
                        @endforeach
                </small></p>
            @endif
        </div>
    @endforeach
</section>
