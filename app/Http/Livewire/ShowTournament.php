<?php

namespace App\Http\Livewire;

use App\Models\TeamsInTournament;
use App\Models\Tournament;
use App\Traits\TournamentsTable\AddTournamentsTable;
use Livewire\Component;

class ShowTournament extends Component
{
    use AddTournamentsTable;

    /** @var bool Переменная открытия-закрытия формы */
    public $modalFormVisible = false;
    /** @var bool Переменная смены табличного отображения */
    public $alternativeVisible = false;
    /** @var bool Переменная, отображающая, нужно ли смена табличного отображения */
    public $isExistsAlternativeVisible;
    /** @var Tournament модель турнира */
    public $tournament;

    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function closeModal()
    {
        $this->modalFormVisible = false;
    }

    public function render()
    {
        $this->isExistsAlternativeVisible = self::checkAllVSAll($this->tournament);
        return $this->alternativeVisible ?
            view('livewire.show-tournament-alternative', ["groups" => self::getGroupData($this->tournament)]) :
            view('livewire.show-tournament');
    }


}
