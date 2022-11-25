{{--<br><br><br><br>--}}
<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>Роботы</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
{{--            <li><a href="#" class="button big-button">ДОБАВИТЬ РОБОТА</a></li>--}}
            @if(Auth::check())
            <li>@livewire('add-robot')</li>
            @endif
        </ul>
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

    <section class="cards wrapper style5" id = "one">
        @foreach($robots as $robot)
        <div class="card">
            <div class="round-image" style="background-image: url('{{$robot->photo}}')"></div>
            @livewire("show-robot", ['robot' => $robot])
            <p>{{$robot->user->name}}</p>
            <p><small>Владелец</small></p>
        </div>
        @endforeach
    </section>


