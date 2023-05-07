<?php

namespace App\Http\Livewire;

use App\Models\Tournament;
use Livewire\Component;

class ShowTournament extends Component
{
    /** @var bool Переменная открытия-закрытия формы*/
    public $modalFormVisible = false;
    /** @var bool Переменная смены табличного отображения*/
    public $alternativeVisible = false;
    /** @var Tournament модель турнира*/
    public $tournament;

    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function closeModal(){
        $this->modalFormVisible = false;
    }

    public function render()
    {
        return $this->alternativeVisible ?
            view('livewire.show-tournament-alternative') :
            view('livewire.show-tournament');
    }
}
