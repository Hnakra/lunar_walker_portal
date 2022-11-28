@if(count($tournaments) == 0)
    <div class="not-found">Турниров с вашим участием нет!</div>
@endif
@if(count($tournaments) > 0)
    @foreach($tournaments as $t)
        {{--                {{($t['info'])}}--}}
        <section class="tournament">
            <h4>{{$t->tournamentName}}</h4>
            <h5>{{$t->placeName}}</h5>
            <h5>{{$t->date_time}}</h5>
            <p>Ваша команда "{{$t->teamName}}" участвует в турнире {{$t->tournamentName}}, на площадке {{$t->placeName}}, дата-время: {{$t->date_time}}. Подтвердите свое участие.</p>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>Участник</th>
                        <th>Подтвердил участие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($t->players as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            @if($user->is_submit)
                                <td><i class="fa fa-check"></i></td>

                            @else
                                <td><i class="fa fa-question"></i></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($t->is_submit)
                    <div class="footer-wrapper">
                        УЧАСТИЕ ПОДТВЕРЖДЕНО!
                    </div>
                @else
                    <div class="footer-wrapper">
                        <a href="/tournaments/submit/{{$t->tournamentId}}/{{$t->teamId}}" class="button big-button">ПОДТВЕРДИТЬ УЧАСТИЕ</a>
                    </div>

                @endif

            </div>
        </section>
    @endforeach
@endif
