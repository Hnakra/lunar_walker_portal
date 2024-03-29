<?php

namespace App\Http\Livewire\Forms;

use App\Models\Robot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use function Livewire\str;

/**
 * Class RobotForm, выводит модальное окно создания и редактирования сущности, сохраняет изменения
 * @package App\Http\Livewire
 */
class RobotForm extends Component
{
    use WithFileUploads;
    // Переменная состояния, редактируется ли сущность (а также id сущности)
    public $current_robot = 0;
    // Переменная открытия-закрытия формы
    public $modalFormVisible = false;
    // Переменные формы
    public $name, $key="", $photo, $notation="";
    // Настройка правил валидации для формы
    protected $rules = [
        'photo' => 'image|max:1024', // 1MB Max
        'name' => 'required|min:2'
    ];
    // Настройка правил сообщений для формы
    protected function getMessages()
    {
        return [
            'name.required' => __('Введите имя робота!'), 'name.min' => __('Имя робота должно быть не меньше 2-х символов!'),
            'photo.image' => __('Добавьте фото робота!'), 'photo.max' => __('Размер фото большой! Добавьте фото меньшего размера!')
        ];
    }
    // метод вызова модельного окна для создания сущности

    public function createShowModal(){
        $this->modalFormVisible = true;
    }
    // метод сохранения новой сущности, редирект

    public function addingRobot(){
        $this->validate($this->rules, $this->getMessages());

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
        $this->photo->storeAs('robots/'.$id, $photoName);

        $this->modalFormVisible = false;
        redirect( "/robots/", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);

    }
    // метод вызова модельного окна для изменения сущности

    public function editShowModal(){
        $robot = Robot::find($this->current_robot);
        $this->name = $robot->name;
        $this->key = $robot->key;
        $this->notation = $robot->notation;
        if(is_readable("storage/robots/$robot->id/$robot->img")) {
            $hash = str()->random(30);
            copy("storage/robots/$robot->id/$robot->img", "storage/livewire-tmp/$hash-meta" . base64_encode($robot->img) . "-.jpg");
            $this->photo = TemporaryUploadedFile::createFromLivewire("public/livewire-tmp/$hash-meta" . base64_encode($robot->img) . "-.jpg");
        }
        $this->modalFormVisible = true;

    }
    // метод изменения сущности, редирект

    public function modifyShowModal(){
        $this->validate($this->rules, $this->getMessages());

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
        $this->photo->storeAs('robots/'.$this->current_robot, $photoName);

        redirect( "/robots/", [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
    }

    public function render()
    {
        return view('livewire.forms.robot-form');
    }

}
