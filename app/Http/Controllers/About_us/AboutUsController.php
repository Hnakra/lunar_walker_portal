<?php

namespace App\Http\Controllers\About_us;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        return view('pages.about_us');
    }
}
