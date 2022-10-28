<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2>ИНФОРМАЦИЯ ОБ ИГРЕ<br>{{$team_1->name}} VS {{$team_2->name}}</h2>
        <h4>{{$game->date_time}}</h4>
        <!--<p>Another fine responsive<br />
            site template freebie<br />
            crafted by <a href="http://html5up.net">HTML5 UP</a>.</p>-->
        <ul class="actions special">
            <li><a href="#" class="button big-button">ВЕСТИ СЧЁТ</a></li>
        </ul>
    </div>
</section>

</div>
<section>
    <div class="block-icon">

        <button class="btn"><i class="fa fa-edit" style="font-size:30px"></i></button>
    </div>
</section>
<section>

    <div class="block-game">

        <div id="block1">
            <div class="rectangle3">{{$game->count_team_1}}</div>
            <div class="heading">{{$team_1->name}}<hr class="hr-line1"></div>
            <div class="subtitle">Состав команды</div>
            @foreach($users_team1 as $user)
            <div class="rectangle1"><a href="#" class="link-name1">{{$user->name}}</a></div>
            @endforeach
            <div class="subtitle">Роботы</div>
            @foreach($list1Robots as $robots)
                @foreach($robots as $robot)
                    <div class="rectangle1"><a href="#" class="link-name1"> {{($robot->name)}}</a></div>
                @endforeach
            @endforeach

        </div>
        <div id="block2">
            <div class="rectangle4">{{$game->count_team_2}}</div>
            <div class="heading">{{$team_2->name}}<hr class="hr-line2"></div>
            <div class="subtitle">Состав команды</div>
            @foreach($users_team2 as $user)
                <div class="rectangle2"><a href="#" class="link-name2">{{$user->name}}</a></div>
            @endforeach
            <div class="subtitle">Роботы</div>
            @foreach($list2Robots as $robots)
                @foreach($robots as $robot)
                    <div class="rectangle2"><a href="#" class="link-name2"> {{$robot->name}}</a></div>
                @endforeach
            @endforeach

        </div>

    </div>

</section>
<div class="block-second">
    <div class="table">
        <table>
            <tr>
                <td class="subtitle">Турнир</td>
                <td align="right"><a href="/games" class="link-name1">{{$tournament->name}}</a></td>
            </tr>
            <tr>
                <td class="subtitle">Площадка</td>
                <td align="right"><a href="/places/{{$place->id}}" class="link-name1">{{$place->name}}</a></td>
            </tr>
            <tr>
                <td class="subtitle">Организатор</td>
                <td align="right"><a href="#" class="link-name1">{{$organizer->name}}</a></td>
            </tr>

        </table>
    </div>
</div>
