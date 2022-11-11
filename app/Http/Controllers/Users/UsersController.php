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
            $user->photo = is_readable("storage/$user->profile_photo_path") ? "../storage/$user->profile_photo_path" : "https://ui-avatars.com/api/?name=".$user->name."&color=7F9CF5&background=EBF4FF";

        }

        return view('pages.users',[
            'users' => $items
        ]);
    }
}
