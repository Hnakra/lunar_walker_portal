<?php

namespace App\Http\Controllers\Robots;

use App\Http\Controllers\Controller;
use App\Models\Robot;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class RobotsController, получает данные и выводит их на странице Роботы
 * @package App\Http\Controllers\Robots
 */
class RobotsController extends Controller
{
    public function index(){
        $items = Robot::all();
        foreach ($items as $robot){
            $robot->user = User::find($robot->id_master);
            $robot->photo = is_readable("storage/robots/$robot->id/$robot->img") ? "../storage/robots/$robot->id/$robot->img" : "https://ui-avatars.com/api/?name=".$robot->name."&color=7F9CF5&background=EBF4FF";
        }
        return view('pages.robots',[
            'robots' => $items
        ]);
    }
}
