<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>{{__('ПОРТАЛ ДЛЯ ПРОВЕДЕНИЯ СОРЕВНОВАНИЙ ПО РОБОФУТБОЛУ')}}</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            <li><a href="games/" class="button big-button">{{__('ПРИНЯТЬ УЧАСТИЕ')}}</a></li>
        </ul>
    </div>
    <a href="#one" class="more scrolly">{{__('Читать далее')}}</a>
</section>
<section id = "one" class="wrapper style5">
    <h1>{{__('Добро пожаловать на сайт проведения соревнований по робофутболу')}}</h1>
    <h3>{{__('Список турниров')}}:</h3>
    @livewire('show-tournament-list')
</section>
