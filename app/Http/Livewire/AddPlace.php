<?php

namespace App\Http\Livewire;

use App\Models\Place;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use function Livewire\str;

class AddPlace extends Component
{
    use WithFileUploads;

    public $modalFormVisible = false;
    public $current_place = 0;
    public $listUsers = [];
    public $name, $address, $id_organizator, $photo, $description = "", $addr_org, $name_urid_org, $site_urid_org, $phone_urid_org, $INN_urid_org;
    public $rules = [
        'name' => 'required|min:2',
        'address' => 'required',
        'id_organizator' => 'required',
        'description' => 'nullable',
        'photo' => 'image|max:1024',
        'addr_org' => 'required',
        'name_urid_org' => 'required',
        'site_urid_org' => 'required',
        'phone_urid_org' => 'required|digits:11',
        'INN_urid_org' => 'required|digits:10'

    ];
    public $messages = [
        'name.required' => "Введите название площадки", 'name.min' => "Название слишком маленькое",
        'address.required' => "Введите адрес",
        'id_organizator.required' => "Нужно выбрать организатора",
        'addr_org.required' => "Введите адрес организации",
        'name_urid_org.required' => "Введите наименование юридического лица",
        'site_urid_org.required' => "Введите сайт площадки",
        'phone_urid_org.required' => "Введите телефон площадки", 'phone_urid_org.digits' => "Введите номер телефона в формате 8xxxxxxxxxx",
        'INN_urid_org.required' => "Введите ИНН организации", 'INN_urid_org.digits' => "ИНН должен содержать 10 цифр"

    ];
    public function createShowModal()
    {
        $this->listUsers = User::all();
/*        foreach($_listUsers as $user){
            $elem = '<option value="'.$user->id.'" >'.$user->name.'</option>';
            array_push($this->listUsers, $elem);
        }
        array_unshift($this->listUsers, '<option  selected>Выберите организатора</option>');*/
        $this->modalFormVisible = true;
    }
    public function addingPlace()
    {
        $this->validate();
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
        $this->photo->storeAs('places/'.$id, $name);

        $this->modalFormVisible = false;

    }

    public function editShowModal(){
        $this->listUsers = User::all();
        $place = Place::find($this->current_place);
        $this-> name = $place->name;
        $this-> address = $place->address;
        $this-> id_organizator = $place->id_organizator;
        $hash = str()->random(30);
        copy("storage/places/$place->id/$place->img", "storage/livewire-tmp/$hash-meta".base64_encode($place->img)."-.jpg");
        $this-> photo = TemporaryUploadedFile::createFromLivewire("public/livewire-tmp/$hash-meta".base64_encode($place->img)."-.jpg");
        $this-> description = $place->description;
        $this-> addr_org = $place->addr_org;
        $this-> name_urid_org = $place->name_urid_org;
        $this-> site_urid_org = $place->site_urid_org;
        $this-> phone_urid_org = $place->phone_urid_org;
        $this-> INN_urid_org = $place->INN_urid_org;

        $this->modalFormVisible = true;
    }
    public function modifyPlace(){

        $this->validate();
        DB::table('places')->where("id", $this->current_place)->update([
            'name' => $this->name,
            'address'=> $this->address,
            'id_organizator'=> $this->id_organizator,
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'img' => $this->photo->getClientOriginalName(),
            'addr_org' => $this->addr_org,
            'name_urid_org' => $this->name_urid_org,
            'site_urid_org' => $this->site_urid_org,
            'phone_urid_org' => $this->phone_urid_org,
            'INN_urid_org' => $this->INN_urid_org,
            'description' => $this->description
        ]);
        $this->photo->storeAs('places/' . $this->current_place, $this->photo->getClientOriginalName());

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
