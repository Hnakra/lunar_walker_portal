<?php

namespace App\Http\Controllers\Robots;

use App\Http\Controllers\Controller;
use App\Models\Robot;
use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function index(){
        $items = Robot::all();

        return view('pages.robots',[
            'robots' => $items
        ]);
    }
}
