<section class="u-clearfix u-section-1" id="sec-47b4">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-text u-text-default u-text-1">{{$place->name}}</p>
        <div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-2" >
            <div class="u-align-center u-container-layout u-similar-container u-container-layout-2"><!--product_image-->
                <img alt="" class="u-image u-image-default u-product-control u-image-2" src="../storage/places/{{$place->id}}/{{$place->img}}" style="height: 20rem;"><!--/product_image-->
                <p class="u-text u-text-default u-text-2"> Адрес: {{$place->address}} </p>
                <p class="u-text u-text-default u-text-2"> <strong>Данные организатора портала</strong> </p>
                <img src="../storage/{{$organizator->profile_photo_path}}" alt="Администратор портала" style="border-radius: 9999px;width: 5rem;height: 5rem;">
                <p class="u-text u-text-default u-text-2"> Имя: {{$organizator->name}} </p>
                <p class="u-text u-text-default u-text-2"> Электронная почта организатора: {{$organizator->name}} </p>
                <p class="u-text u-text-default u-text-2"> Адрес организации: {{$place->addr_org}} </p>
                <p class="u-text u-text-default u-text-2"> Наименование юридического лица организатора: {{$place->name_urid_org}} </p>
                <p class="u-text u-text-default u-text-2"> Сайт площадки: <a href="{{$place->site_urid_org}}">{{$place->site_urid_org}}</a> </p>
                <p class="u-text u-text-default u-text-2"> Телефон площадки: {{$place->phone_urid_org}} </p>
                <p class="u-text u-text-default u-text-2"> ИНН организации: {{$place->INN_urid_org}} </p>

            </div>
        </div>
    </div>
</section>
