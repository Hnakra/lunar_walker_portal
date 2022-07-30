<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddPlace extends Component
{
    use WithFileUploads;


    public $modalFormVisible = false;
    public $listUsers = [];
    public $name, $address, $id_organizator, $photo, $addr_org, $name_urid_org, $site_urid_org, $phone_urid_org, $INN_urid_org;

    public function createShowModal()
    {
        $_listUsers = User::all();
        foreach($_listUsers as $user){
            $elem = '<option value="'.$user->id.'" >'.$user->name.'</option>';
            array_push($this->listUsers, $elem);
        }
        array_unshift(   $this->listUsers, '<option  selected>Выберите организатора</option>');
        $this->modalFormVisible = true;
    }
    public function addingPlace()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
        $name = $this->photo->getClientOriginalName();
        $id = DB::table('places')->insertGetId([
            'name'=> $this->name,
            'address'=> $this->address,
            'id_organizator'=> $this->id_organizator,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'img' => $name,
            'addr_org' => $this->addr_org,
            'name_urid_org' => $this->name_urid_org,
            'site_urid_org' => $this->site_urid_org,
            'phone_urid_org' => $this->phone_urid_org,
            'INN_urid_org' => $this->INN_urid_org
        ]);
        $this->photo->storeAs('public/places/'.$id, $name);

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
