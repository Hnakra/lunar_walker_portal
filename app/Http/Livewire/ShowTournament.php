<?php

namespace App\Http\Livewire;

use App\Models\TeamsInTournament;
use App\Models\Tournament;
use App\Traits\TournamentsTable\AddTournamentsTable;
use App\Traits\TournamentsTable\PlayOffTrait;
use Livewire\Component;

class ShowTournament extends Component
{
    use AddTournamentsTable;
    use PlayoffTrait;

    /** @var bool Переменная открытия-закрытия формы */
    public $modalFormVisible = false;
    /** @var bool Переменная смены табличного отображения */
    public $alternativeVisible = false;
    /** @var bool Переменная, отображающая, нужно ли смена табличного отображения */
    public $isExistsAlternativeVisible;
    /** @var Tournament модель турнира */
    public $tournament;

    public $refreshTime;

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
        $this->refreshTime = date('H:i:s');
        if ($this->tournament->is_playoff) {
            $this->isExistsAlternativeVisible = true;
            return $this->alternativeVisible ?
                view('livewire.show-tournament-playoff', ["rounds" => self::getPlayoffData($this->tournament)]) :
                view('livewire.show-tournament');
        } else {
            $this->isExistsAlternativeVisible = self::checkAllVSAll($this->tournament);
            return $this->alternativeVisible ?
                view('livewire.show-tournament-alternative', ["groups" => self::getGroupData($this->tournament)]) :
                view('livewire.show-tournament');
        }
    }


}
