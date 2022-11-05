<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddRobot extends Component
{
    use WithFileUploads;

    public $modalFormVisible = false;
    public $name, $key, $photo, $notation, $placeId;
    protected $rules = [
        'photo' => 'image|max:1024', // 1MB Max

    ];
    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    public function addingRobot(){
        $this->validate();
        $photoName = $this->photo->getClientOriginalName();
        $is_working = false;
        $id_master = Auth::user()->id;
        $id = DB::table('robots')->insertGetId([
            'name'=> $this->name,
            'is_working'=> $is_working,
            'id_master'=> $id_master,
            /*'id_place'=> $this->placeId,*/
            'key'=> $this->key,
            'notation'=> $this->notation,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'img' => $photoName,
        ]);
        $this->photo->storeAs('public/robots/'.$id, $photoName);

        $this->modalFormVisible = false;
    }
    public function render()
    {
        return view('livewire.add-robot');
    }

}
