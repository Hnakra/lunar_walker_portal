<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>{{__('ПЛОЩАДКА')}} {{$place->name}}</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        @if( Auth::check() && Auth::user()->isOwnerOrAdmin($organizator->id))
            {{--<p>тут будет кнопка редактирования площадки...</p>--}}

            @livewire('forms.place-form', ['current_place' => $place->id])
        @endif
    </div>
    <a href="#one" class="more scrolly">{{__('Читать далее')}}</a>
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
        <p><span>{{__('Адрес')}}: </span>{{$place->address}}</p>
        <p><span>{{__('Организатор')}}: </span>
            @livewire('show-user', ['user' => $organizator])
        </p>
        <p><span>{{__('Адрес организации')}}: </span>{{$place->addr_org}}</p>
        <p><span>{{__('Наименование юридического лица организатора')}}: </span>{{$place->name_urid_org}}</p>
        <p><span>{{__('Сайт площадки')}}: </span><a class="user" href="{{$place->site_urid_org}}">{{$place->site_urid_org}}</a></p>
        <p><span>{{__('Телефон площадки')}}: </span>{{$place->phone_urid_org}}</p>
        <p><span>{{__('ИНН организации')}}: </span>{{$place->INN_urid_org}}</p>
    </div>

</section>
