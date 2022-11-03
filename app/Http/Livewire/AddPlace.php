<?php

namespace App\Http\Livewire;

use App\Models\Place;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddPlace extends Component
{
    use WithFileUploads;

    public $modalFormVisible = false;
    public $current_place = 0;
    public $listUsers = [];
    public $name, $address, $id_organizator, $photo, $description, $addr_org, $name_urid_org, $site_urid_org, $phone_urid_org, $INN_urid_org;

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
            'INN_urid_org' => $this->INN_urid_org,
            'description' => $this->description
        ]);
        $this->photo->storeAs('public/places/'.$id, $name);

        $this->modalFormVisible = false;

    }

    public function editShowModal(){
        $place = Place::find($this->current_place);
        $this-> name = $place->name;
        $this-> id_organizator = $place->id_organizator;
        $this-> photo = $place->photo;
        $this-> description = $place->description;
        $this-> addr_org = $place->addr_org;
        $this-> name_urid_org = $place->name_urid_org;
        $this-> site_urid_org = $place->site_urid_org;
        $this-> phone_urid_org = $place->phone_urid_org;
        $this-> INN_urid_org = $place->INN_urid_org;
/*        $this->users = User::all();
        $team = Team::where("id", $this->current_team)->get()->first();
        $this->selected_users_id = Player::where("id_team", $team->id)->pluck('id_user')->toArray();
        $this->name = $team->name;*/
        $this->modalFormVisible = true;
    }
    public function modifyPlace(){
        DB::table('places')->where("id", $this->current_place)->update([
            'name' => $this->name,

        ]);
        redirect("/places/".$this->current_place, [\App\Http\Controllers\Teams\TeamsController::class, 'index']);

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
