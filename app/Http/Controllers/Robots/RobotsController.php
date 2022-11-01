<?php

namespace App\Http\Controllers\Robots;

use App\Http\Controllers\Controller;
use App\Models\Robot;
use App\Models\User;
use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function index(){
        $items = Robot::all();
        foreach ($items as $robot){
            $robot->user = User::find($robot->id_master);
        }
        return view('pages.robots',[
            'robots' => $items
        ]);
    }
}
