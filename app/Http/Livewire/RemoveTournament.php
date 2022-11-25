<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveTournament extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменная id турнира, который требуется удалить

    public $current_tournament;
    // метод открытия модального окна

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    // метод удаления сущности, редирект

    public function remove(){
        Tournament::where("id", $this->current_tournament)->delete();
        DB::table('teams_in_tournaments')->where('id_tournament', $this->current_tournament)->delete();
        DB::table('submit_tournaments')->where('id_tournament', $this->current_tournament)->delete();
        Game::where("id_tournament", $this->current_tournament)->delete();
        $this->modalFormVisible = false;
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.remove-tournament');
    }
}
