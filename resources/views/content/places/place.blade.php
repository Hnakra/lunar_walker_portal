<section class="u-clearfix u-section-1" id="sec-47b4">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-text u-text-default u-text-1">{{$place->name}}</p>



        <div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-2" >
            <div class="u-align-center u-container-layout u-similar-container u-container-layout-2"><!--product_image-->
                <img alt="" class="u-image u-image-default u-product-control u-image-2" src="../storage/places/{{$place->id}}/{{$place->img}}" style="height: 20rem;"><!--/product_image-->
                <p class="u-text u-text-default u-text-2"> Адрес: {{$place->address}} </p>
                <p class="u-text u-text-default u-text-2"> <strong>Данные организатора портала</strong> </p>
                <img src="../storage/{{$organizator->profile_photo_path}}"  style="border-radius: 9999px;width: 5rem;height: 5rem;">
                <p class="u-text u-text-default u-text-2"> Имя: {{$organizator->name}} </p>
                <p class="u-text u-text-default u-text-2"> Электронная почта организатора: {{$organizator->name}} </p>
                <p class="u-text u-text-default u-text-2"> Адрес организации: {{$place->addr_org}} </p>
                <p class="u-text u-text-default u-text-2"> Наименование юридического лица организатора: {{$place->name_urid_org}} </p>
                <p class="u-text u-text-default u-text-2"> Сайт площадки: <a href="{{$place->site_urid_org}}">{{$place->site_urid_org}}</a> </p>
                <p class="u-text u-text-default u-text-2"> Телефон площадки: {{$place->phone_urid_org}} </p>
                <p class="u-text u-text-default u-text-2"> ИНН организации: {{$place->INN_urid_org}} </p>

{{--                ---Список команд -----}}
                <a href="/places/{{$place->id}}/teams">
                    <x-jet-button>Список команд</x-jet-button>

                </a>
{{--                -----}}
                @livewire('add-robot',["placeId" => $place->id])

                <strong> Список роботов: </strong>
                @foreach($robots as $robot)
                    <div>
                        <img src="../storage/robots/{{$robot->id}}/{{$robot->img}}"  style="margin-left: auto;margin-right: auto; border-radius: 9999px;width: 5rem;height: 5rem;">
                        Имя робота: {{$robot->name}} <br>
                        Добавлен: {{$robot->created_at}} <br>
                        Последнее обновление: {{$robot->updated_at}} <br>
                        Дополнительно: {{$robot->notation}} <br>
                        ID владельца: {{$robot->id_master}} <br>
                        Состояние: @if($robot->is_working)
                            <p style="color: green"> Работает </p>
                        @else
                            <p style="color: red"> Не работает </p>
                        @endif

                    </div>

                @endforeach
            </div>
        </div>
    </div>
</section>
