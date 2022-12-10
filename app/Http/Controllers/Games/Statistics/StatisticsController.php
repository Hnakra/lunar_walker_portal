<?php

namespace App\Http\Controllers\Games\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class StatisticsController, получает данные и выводит их на странице Статистика
 * @package App\Http\Controllers\Games\Statistics
 */
class StatisticsController extends Controller
{
    public function index(){
        return view('pages.statistics');
    }
}
