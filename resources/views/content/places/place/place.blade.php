<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ПЛОЩАДКа {{$place->name}}</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        @if( Auth::check() && !Auth::user()->isUser())
            <p>тут будет кнопка редактирования площадки...</p>

            @livewire('add-place', ['current_place' => $place->id])
        @endif
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

<!-- Places -->
<section id="one" >
{{--
    @livewire('edit-place', ['place' => $place])
--}}
    <div class="block">
        <div>
            <img alt="" class="" src="../storage/places/{{$place->id}}/{{$place->img}}" style="height: 20rem;"><!--/product_image-->
        </div>
        <div class="description">
            {{$place->description}}
        </div>
    </div>

    <div class="info">
        <p><span>Адрес: </span>{{$place->address}}</p>
        <p><span>Организатор: </span> <a class="user" href="#">{{$organizator->name}}</a></p>
        <p><span>Адрес организации: </span>{{$place->addr_org}}</p>
        <p><span>Наименование юридического лица организатора: </span>{{$place->name_urid_org}}</p>
        <p><span>Сайт площадки: </span><a class="user" href="{{$place->site_urid_org}}">{{$place->site_urid_org}}</a></p>
        <p><span>Телефон площадки: </span>{{$place->phone_urid_org}}</p>
        <p><span>ИНН организации: </span>{{$place->INN_urid_org}}</p>
    </div>

</section>
