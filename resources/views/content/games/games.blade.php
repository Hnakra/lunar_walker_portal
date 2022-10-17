<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИГРЫ</h2>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            <li>@livewire('add-tournament')</li>
{{--            <li><a href="#" class="button big-button">СОЗДАТЬ ТУРНИР</a></li>--}}
        </ul>
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>

<section id="one" class="wrapper style5">
    <div class="inner">
        @foreach($tournaments as $tournament)
        <section class="tournament">
            <h4>{{$tournament->name}}</h4>
            <h5>{{$tournament->place_name}}</h5>
            <h5>{{$tournament->date_time}}</h5>
{{--            {{print_r($tournament)}}--}}
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Время</th>
                        <th>Команды</th>
                        <th>Счет</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>9:10</td>
                        <td>Старкит VS Космос</td>
                        <td>0:0</td>
                    </tr>
                    <tr>
                        <td>9:50</td>
                        <td>Космос VS Вперед</td>
                        <td>0:0</td>
                    </tr>
                    <tr>
                        <td>10:30</td>
                        <td> Вперед VS Старкит</td>
                        <td>0:0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <ul class="actions special">
                <li><a href="#" class="button big-button">ДОБАВИТЬ ИГРУ</a></li>
            </ul>
            <!--ЗДЕСЬ БУДЕТ ЛИНИЯ -->
        </section>
        @endforeach
    </div>
</section>


