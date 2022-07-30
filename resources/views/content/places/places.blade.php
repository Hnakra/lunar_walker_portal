<section class="u-clearfix u-section-1" id="sec-47b4">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-text u-text-default u-text-1">Выберите платформу для участия в соревновании</p>
    </div>
</section>

@if( Auth::user()->id_role == 1)
    <section class="u-clearfix" >
{{--
        @include('for_different_roles.admin.add_place')
--}}
        @livewire('add-place')
    </section>
@endif
<section class="u-align-center u-clearfix u-section-2" id="sec-655c">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1"><!--products--><!--products_options_json--><!--{"type":"Recent","source":"","tags":"","count":""}--><!--/products_options_json-->
        <div class="u-expanded-width u-products u-products-1">
            <div class="u-repeater u-repeater-1">
                @foreach($places as $place)
                <!--product_item-->
                <div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-2" data-href="/places/{{$place->id}}">
                    <div class="u-container-layout u-similar-container u-container-layout-2"><!--product_image-->
                        <img alt="" class="u-image u-image-default u-product-control u-image-2" src="storage/places/{{$place->id}}/{{$place->img}}" data-image-width="288" data-image-height="283"><!--/product_image-->
                        <p class="u-text u-text-default u-text-2"> {{$place->name}} </p>
                    </div>
                </div><!--/product_item-->
                    @endforeach
            </div>
        </div><!--/products-->
    </div>
</section>




