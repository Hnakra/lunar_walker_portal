<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class MainController, выводит страницу Главная
 * @package App\Http\Controllers\Main
 */
class MainController extends Controller
{
    public function index(){
        return view('pages.main');
    }
}
