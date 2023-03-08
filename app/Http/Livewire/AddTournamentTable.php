<?php

namespace App\Http\Livewire;

use App\Traits\TournamentsTable\AddTournamentsTable;
use Livewire\Component;

class AddTournamentTable extends Component
{
    use AddTournamentsTable;
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    public $id_tournament;
    public $listTables = ['all_vs_all'=>"Все со всеми"], $selectedTable;
    public $interval = 10, $max_seconds_match = 300;
    protected $rules = [
        'selectedTable' => 'required'
    ];
    protected $messages = [
        'date.required' => 'Выберите способ генерации игр'
    ];

    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function submitShowModal(){
        $this->validate();
        $this->makeGames($this->selectedTable, $this->id_tournament);
        redirect("/games", [\App\Http\Controllers\Games\GamesController::class, 'index']);
    }
    public function render()
    {
        return view('livewire.add-tournament-table');
    }
}
