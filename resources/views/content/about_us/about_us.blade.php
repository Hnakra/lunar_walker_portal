<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>{{__('О НАС')}}</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
{{--            <li><p>УЗНАЙ О НАС БОЛЬШЕ</p></li>--}}
            <a href="#one" class="more scrolly">{{__('Читать далее')}}</a>
        </ul>
    </div>
</section>
<section class = "block-about-us" id="one">
    <h1>{{__('ПОГОВОРИМ О НАС')}}</h1>
    <p><span class="image left"><img src="images/img.png" alt="" /></span>{{__('Данный сайт создавался, чтобы вы могли играть в футбол своими роботами! Создайте робота, управляйте им лично на любой из наших площадок, продумывайте тактику, тренируйтесь, побеждайте!')}}</p>
    <p><span class="image right"><img src="images/img_1.png" alt="" /></span>{{__('Добавьте Ваших роботов на площадку и присоединитесь к одному из близжайших соревнований. Вы всегда можете ознакомиться со статистикой соревнований!')}}</p>
    <p>{{__('Если вы организатор, и хотите, чтобы средствами портала на вашей площадке проводились турниры - обратитесь к Администратору портала через форму обратной связи.')}}</p>

    @livewire('send-feedback')
</section>
