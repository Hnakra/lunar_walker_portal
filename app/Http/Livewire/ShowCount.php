<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

/**
 * Class ShowCount, класс живого отображения счета
 * @package App\Http\Livewire
 */
class ShowCount extends Component
{
    // переменная игры и номера команды в даннной игре
    public $game, $number_team;
    // метод отображения счета игры
    public function refresh(){
        $this->game = Game::find($this->game->id);
    }

    public function render()
    {
        return view('livewire.show-count');
    }
}
