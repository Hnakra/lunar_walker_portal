<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>Мои Турниры</h2>
        <p>Подтвердите участие в<br />
            грядущих турнирах</p>
    </div>
    <a href="#one" class="more scrolly">Читать далее</a>
</section>
{{--
{{($tournaments[0]['team'])}}
--}}
<section id="one" class="wrapper style5">
    <div class="inner">
        @if(count($tournaments) == 0)
        <div class="not-found">Турниров с вашим участием нет!</div>
        @endif
        @if(count($tournaments) > 0)
            @foreach($tournaments as $t)
{{--                {{($t['info'])}}--}}
                    <section class="tournament">
                        <h4>{{$t['info']->name}}</h4>
                        <h5>{{$t['info']->placeName}}</h5>
                        <h5>{{$t['info']->date_time}}</h5>
                        <p>Ваша команда "{{$t['team']->first()['teamName']}}" участвует в турнире {{$t['info']->name}}, на площадке {{$t['info']->placeName}}, дата-время: {{$t['info']->date_time}}. Подтвердите свое участие.</p>
                        <div>
                            <table>
                                <thead>
                                <tr>
                                    <th>Участник</th>
                                    <th>Подтвердил участие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($t['team'] as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        @if($user->is_submit)
                                            <td><i class="fa fa-check"></i></td>

                                        @else
                                            <td><i class="fa fa-times"></i></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($t['is_submit'])
                                <div class="footer-wrapper">
                                    УЧАСТИЕ ПОДТВЕРЖДЕНО!
                                </div>
                            @else
                                <div class="footer-wrapper">
                                    <a href="/tournaments/submit" class="button big-button">ПОДТВЕРДИТЬ УЧАСТИЕ</a>
                                </div>

                            @endif

                        </div>
                    </section>
            @endforeach
        @endif
{{--
        <section class="tournament">
            <h4>Название турнира</h4>
            <h5>Название площадки</h5>
            <h5>27.01.2022 12:23:00</h5>
            <p>Ваша команда Старкит участвует в турнире Робоармия-2022, на площадке Парк Партиот, дата-время: 27.01.2022 12:00. Подтвердите свое участие.</p>

            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Участник</th>
                        <th>Подтвердил участие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Николай Еремин</td>
                        <td><i class="fa fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Александр Потапов</td>
                        <td><i class="fa fa-check"></i></td>
                    </tr>
                    </tbody>
                </table>
                <div class="footer-wrapper">
                    УЧАСТИЕ ПОДТВЕРЖДЕНО!
                </div>

            </div>
        </section>--}}

    </div>
</section>


