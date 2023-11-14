<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectLanguage extends Component
{

    public function changeLanguage(string $language){
        dd($language);
    }
    public function render()
    {
        return view('livewire.select-language');
    }
}
