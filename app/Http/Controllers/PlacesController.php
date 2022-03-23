<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function index(){
        $places = Place::all();
        return view('pages.places',[
            'places' => $places
        ]);
    }
}
