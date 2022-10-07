<?php

namespace App\Http\Controllers\Games\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(){
/*        $items = Robot::all();

        return view('pages.robots',[
            'robots' => $items
        ]);*/
        return view('pages.statistics');
    }
}
