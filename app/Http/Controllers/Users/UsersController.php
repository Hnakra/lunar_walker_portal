<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Robot;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        $items = User::all();
        foreach ($items as $user){
            $user->teams = Player::where('id_user', $user->id)->leftJoin('teams', 'teams.id', '=', 'players.id_team')->get();
        }

        return view('pages.users',[
            'users' => $items
        ]);
    }
}
