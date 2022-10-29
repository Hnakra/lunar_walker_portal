<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class ShowCount extends Component
{
    public $game, $number_team;
    public function refresh(){
        $this->game = Game::find($this->game->id);
    }

    public function render()
    {
        return view('livewire.show-count');
    }
}
