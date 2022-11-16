<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class RemoveGame extends Component
{
    public $modalFormVisible = false;
    public $current_game;

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    public function remove(){
        Game::where("id", $this->current_game)->delete();
        $this->modalFormVisible = false;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.remove-game');
    }
}
