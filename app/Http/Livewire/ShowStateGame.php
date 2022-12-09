<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class ShowStateGame extends Component
{
    public $game, $id_game;
    public function refresh()
    {
        $this->game = Game::find($this->id_game);
    }
    public function getTime()
    {
        $date = strtotime(date("Y-m-d H:i:s", strtotime('now')))-strtotime($this->game->datetime_state);
        return date('i:s', $date);
    }
    public function getFixedTime()
    {
        return date('i:s', strtotime($this->game->datetime_state));
    }
    public function render()
    {
        $this->game = Game::find($this->id_game);
        return view('livewire.show-state-game');
    }
}
