<?php

namespace App\Http\Livewire;

use App\Models\Place;
use App\Models\Tournament;
use Livewire\Component;

class RemovePlace extends Component
{
    public $modalFormVisible = false;
    public $current_place;
    public $errorMessage = "";

    public function confirmRemove(){
        $this->modalFormVisible = true;
    }
    public function remove(){
        if (Tournament::where("id_place", $this->current_place)->get()->isEmpty()){
            Place::where("id", $this->current_place)->delete();
            $this->modalFormVisible = false;
            redirect("/places", [\App\Http\Controllers\Places\PlacesController::class, 'index']);
        }
        else{
            $this->errorMessage = "Есть турниры, на которых завязаны площадка!";
        }
    }
    public function render()
    {
        return view('livewire.remove-place');
    }
}
