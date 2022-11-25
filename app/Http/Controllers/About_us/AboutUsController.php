<?php

namespace App\Http\Controllers\About_us;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class AboutUsController, нужен для отображения страницы "О нас"
 * @package App\Http\Controllers\About_us
 */
class AboutUsController extends Controller
{
    public function index(){
        return view('pages.about_us');
    }
}
