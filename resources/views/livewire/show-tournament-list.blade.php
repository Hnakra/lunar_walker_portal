<div class="table-wrapper">
    <table>
        <thead>
        <tr>
            <th>Дата @include("layouts.filter", ['type'=>'date']) </th>
            <th>Турнир @include("layouts.filter", ['type'=>'tournamentName'])</th>
            <th>Площадка @include("layouts.filter", ['type'=>'placeName'])</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tournaments as $t)
            <tr>
                <td>{{$t->get_date()}}</td>
                <td>@livewire('show-tournament', ['tournament' => $t], key("tournament-$t->id"))</td>
                <td>{{$t->placeName}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
