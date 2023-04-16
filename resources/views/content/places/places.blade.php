<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ПЛОЩАДКИ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        @if(Auth::check() && !Auth::user()->isUser())
            @livewire('place-form')
        @endif
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

<!-- Places -->
<section id="one" class="wrapper alt style2">
    @foreach($places as $place)
         <section class="spotlight">
             <div class="container" style="background-image: url('storage/places/{{$place->id}}/{{$place->img}}')"></div>
            <div class="content">
                <h2>{{$place->name}}</h2>
{{--                <p>{{print_r($place)}}</p>--}}
                <p>{{$place->address}}</p>
                <p><a href="/places/{{$place->id}}" class="button big-button">ПОДРОБНЕЕ</a></p>
            </div>
        </section>

    @endforeach
</section>






