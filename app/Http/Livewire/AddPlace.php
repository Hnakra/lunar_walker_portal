<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddPlace extends Component
{
    public $modalFormVisible = false;
    public $name = "";

    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function addingPlace()
    {
        $this->modalFormVisible = false;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.add-place');
    }
}
