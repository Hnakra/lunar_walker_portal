<?php

namespace App\Http\Controllers\Places\Place;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Robot;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class PlaceController, , получает данные и выводит их на странице Площадка
 * @package App\Http\Controllers\Places\Place
 */
class PlaceController extends Controller
{
    public function index($id)
    {
        $place = Place::where('id', $id)->get()->first();
//        $organizator = User::addSelect([
//            'id' => Place::select('id_organizator')->where('id_organizator', 'users.id')
//        ])->get()->first();
        $organizator = $place->id_organizator !== 0 ? User::find($place->id_organizator) : null;
        return view('pages.place', [
            'place' => $place,
            'organizator' => $organizator,
        ]);

    }
}
