<?php

namespace App\Http\Livewire;

use App;
use Livewire\Livewire;
use Request;
use Livewire\Component;
use Route;
use Session;

class SelectLanguage extends Component
{
    public $urlRedirect;

    public function changeLanguage(string $language)
    {
        App::setLocale($language);
        Session::put('locale', $language);
        return redirect($this->urlRedirect ?? '/');
    }

    public function render()
    {
        return view('livewire.select-language');
    }
}
