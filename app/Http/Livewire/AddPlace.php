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

/**
 * Class AddPlace, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 */
class AddPlace extends Component
{
    use WithFileUploads;
    // Переменная открытия-закрытия формы

    public $modalFormVisible = false;
    // Переменная состояния, редактируется ли сущность (а также id сущности)

    public $current_place = 0;
    // Переменные отображения

    public $listUsers = [];
    // Переменные формы

    public $name, $address, $id_organizator, $photo, $description = "", $addr_org, $name_urid_org, $site_urid_org, $phone_urid_org, $INN_urid_org;
    // Настройка правил валидации для формы
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
    // Настройка правил сообщений для формы
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
    // метод вызова модельного окна для создания сущности

    public function createShowModal()
    {
        $this->listUsers = User::where("id_role", 3)->get();

        $this->modalFormVisible = true;
    }
    // метод сохранения новой сущности, редирект

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
        User::where('id', $this->id_organizator)->update([
            "id_role" => 2
        ]);
        $this->photo->storeAs('places/'.$id, $name);
        redirect("/places/".$id, [\App\Http\Controllers\Places\Place\PlaceController::class, 'index']);

        $this->modalFormVisible = false;

    }
    // метод вызова модельного окна для изменения сущности

    public function editShowModal(){
        $this->listUsers = User::where("id_role", 3)->get();
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
    // метод изменения сущности, редирект

    public function modifyPlace(){

        $this->validate();

        $old_id_organizator = Place::find($this->current_place)->id_organizator;
        User::where('id', $old_id_organizator)->update([
            "id_role" => 3
        ]);

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


        User::where('id', $this->id_organizator)->update([
            "id_role" => 2
        ]);

        $this->photo->storeAs('places/' . $this->current_place, $this->photo->getClientOriginalName());

        redirect("/places/".$this->current_place, [\App\Http\Controllers\Places\Place\PlaceController::class, 'index']);

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
