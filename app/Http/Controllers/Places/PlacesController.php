<?php

namespace App\Http\Controllers\Places;
use App\Http\Controllers\Controller;
use App\Models\Place;

class PlacesController extends Controller
{
    public function index(){
        $places = Place::all();

        return view('pages.places',[
            'places' => $places
        ]);
    }
}
