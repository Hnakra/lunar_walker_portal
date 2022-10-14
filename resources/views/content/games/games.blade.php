<br><br><br><br>
@livewire('add-tournament')
@foreach($tournaments as $tournament)
{{--    Можно так--}}
    <div>{{$tournament['name']}}</div>
{{--    А можно так--}}
    <div>{{$tournament->description}}</div>
    <div>{{$tournament->date_time}}</div>
    <hr/>
@endforeach


