<?php

namespace App\Http\Livewire;

use App\Models\Robot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use function Livewire\str;

class AddRobot extends Component
{
    use WithFileUploads;

    public $current_robot = 0;
    public $modalFormVisible = false;
    public $name, $key="", $photo, $notation="";
    protected $rules = [
        'photo' => 'image|max:1024', // 1MB Max
        'name' => 'required|min:2'
    ];
    public $messages = [
        'name.required' => "Введите имя робота!", 'name.min' => "Имя робота должно быть не меньше 2-х символов!",
        'photo.image' => "Добавьте фото робота!", 'photo.max' => "Размер фото большой! Добавьте фото меньшего размера!"
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
            'key'=> $this->key,
            'notation'=> $this->notation,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'img' => $photoName,
        ]);
        $this->photo->storeAs('public/robots/'.$id, $photoName);

        $this->modalFormVisible = false;
        redirect( "/robots/", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);

    }

    public function editShowModal(){
        $robot = Robot::find($this->current_robot);
        $this->name = $robot->name;
        $this->key = $robot->key;
        $this->notation = $robot->notation;
        if(is_readable("storage/robots/$robot->id/$robot->img")) {
            $hash = str()->random(30);
            copy("storage/robots/$robot->id/$robot->img", "storage/livewire-tmp/$hash-meta" . base64_encode($robot->img) . "-.jpg");
            $this->photo = TemporaryUploadedFile::createFromLivewire("storage/livewire-tmp/$hash-meta" . base64_encode($robot->img) . "-.jpg");
        }
        $this->modalFormVisible = true;

    }
    public function modifyShowModal(){
        $this->validate();
        $robot = Robot::find($this->current_robot);
        $photoName = $this->photo->getClientOriginalName();
        $is_working = $robot->is_working;
        $id_master = $robot->id_master;
        DB::table('robots')->where('id', $this->current_robot)
        ->update([
                'name'=> $this->name,
                'is_working'=> $is_working,
                'id_master'=> $id_master,
                'key'=> $this->key,
                'notation'=> $this->notation,
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
                'img' => $photoName,
        ]);
        $this->photo->storeAs('public/robots/'.$this->current_robot, $photoName);

        redirect( "/robots/", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.add-robot');
    }

}
