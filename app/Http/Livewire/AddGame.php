<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddGame extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    //    Переменные формы
    public $id_tournament;
    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function submitShowModal(){
        $this->modalFormVisible = false;
        // редирект на страницу, чтобы перерисовать ее с новыми изменениями
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.add-game');
    }
}
