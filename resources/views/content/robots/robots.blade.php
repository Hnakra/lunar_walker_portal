<br><br><br><br>
@foreach($robots as $robot)
    <div style="padding: 10px">
        @livewire('show-robot', ['robot' => $robot])
    </div>
@endforeach
