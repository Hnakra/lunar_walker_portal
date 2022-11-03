<?php

namespace App\Http\Controllers\Places\Place;
use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Robot;
use App\Models\User;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index($id){
        $place = Place::where('id', $id)->get()->first();
        $organizator = User::addSelect([
            'id' => Place::select('id_organizator')->where('id_organizator', 'users.id')
        ])->get()->first();
/*        $robots = Robot::where('id_place', $place->id)->get();*/
        return view('pages.place',[
            'place' => $place,
            'organizator' => $organizator,
/*            'robots'=>$robots*/
        ]);

    }
}
