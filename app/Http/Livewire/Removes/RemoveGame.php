<?php

namespace App\Http\Livewire\Removes;

use App\Models\Game;
use Livewire\Component;

/**
 * Class RemoveGame, удаление сущности по id
 * @package App\Http\Livewire
 */
class RemoveGame extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменная id игры, которую требуется удалить
    public $current_game;
    // метод открытия модального окна
    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    // метод удаления сущности, редирект
    public function remove(){
        Game::where("id", $this->current_game)->delete();
        $this->modalFormVisible = false;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.removes.remove-game');
    }
}
