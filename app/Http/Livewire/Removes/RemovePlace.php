<?php

namespace App\Http\Livewire\Removes;

use App\Models\Place;
use App\Models\Tournament;
use Livewire\Component;

class RemovePlace extends Component
{
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменная id площадки, которую требуется удалить
    public $current_place;
    // переменная отображения ошибки на случай, если удаление невозможно
    public $errorMessage = "";
    // метод открытия модального окна

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    // метод удаления сущности, редирект

    public function remove(){
        if (Tournament::where("id_place", $this->current_place)->get()->isEmpty()){
            Place::where("id", $this->current_place)->delete();
            $this->modalFormVisible = false;
            redirect("/places", [\App\Http\Controllers\Places\PlacesController::class, 'index']);
        }
        else{
            $this->errorMessage = __('Есть турниры, на которых завязаны площадка!');
        }
    }
    public function render()
    {
        return view('livewire.removes.remove-place');
    }
}
