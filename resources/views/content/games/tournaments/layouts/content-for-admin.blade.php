 @foreach($tournaments as $t)                    {{--{{($t)}} <br/> <br/>--}}

    <section class="tournament">
        <h4>{{$t->name}}</h4>
        <h5>{{$t->placeName}}</h5>
        <h5>{{$t->date_time}}</h5>
        <br/>
        @foreach($t->teams as $team)
            <h5>{{__('Команда')}}:{{$team->name}}</h5>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>{{__('Участник')}}</th>
                        <th>{{__('Подтвердил участие')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($team->players as $user)
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



            </div>
        @endforeach

    </section>
@endforeach
