<?php

namespace App\Http\Controllers\Places;
use App\Http\Controllers\Controller;
use App\Models\Place;

/**
 * Class PlacesController, получает данные и выводит их на странице Площадки
 * @package App\Http\Controllers\Places
 */
class PlacesController extends Controller
{
    public function index(){
        $places = Place::all();

        return view('pages.places',[
            'places' => $places
        ]);
    }
}
