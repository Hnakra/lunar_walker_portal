<br><br><br><br>
@livewire('add-robot')
@foreach($robots as $robot)
    <div style="padding: 10px">
        @livewire('show-robot', ['robot' => $robot])
    </div>
@endforeach
