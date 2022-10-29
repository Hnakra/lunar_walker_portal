<section id="one" class="wrapper style5">
    <div class="inner">
        <div class="head-button">
            <a href="../{{$game->id}}"><i class="fa fa-chevron-left"></i></a>
        </div>
        @livewire('edit-count', ['game' => $game])

    </div>
</section>
