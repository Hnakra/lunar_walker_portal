<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

/**
 * Class MainController, выводит страницу Главная
 * @package App\Http\Controllers\Main
 */
class MainController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::orderBy('date_time', 'desc')->get();
        return view('pages.main', [
            'tournaments' => $tournaments
        ]);
    }
}
