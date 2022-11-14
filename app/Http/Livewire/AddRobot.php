<?php

namespace App\Http\Livewire;

use App\Models\Robot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class AddRobot extends Component
{
    use WithFileUploads;

    public $current_robot = 0;
    public $modalFormVisible = false;
    public $name, $key, $photo, $notation;
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
            'key'=> $this->key,
            'notation'=> $this->notation,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'img' => $photoName,
        ]);
        $this->photo->storeAs('public/robots/'.$id, $photoName);

        $this->modalFormVisible = false;
    }

    public function editShowModal(){
        $robot = Robot::find($this->current_robot);
        $this->name = $robot->name;
        $this->key = $robot->key;
        $this->notation = $robot->notation;
/*        copy("storage/robots/$robot->id/$robot->img", "storage/livewire-tmp/kek-meta".base64_encode($robot->img)."-.jpg");
        $this->photo = TemporaryUploadedFile::createFromLivewire("storage/livewire-tmp/kek-meta".base64_encode($robot->img)."-.jpg");*/

        $this->modalFormVisible = true;
    }
    public function modifyShowModal(){
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
        redirect( "/robots/", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.add-robot');
    }

}
