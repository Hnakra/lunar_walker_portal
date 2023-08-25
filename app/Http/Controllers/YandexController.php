<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Livewire\str;

class YandexController extends Controller
{
    public function loginWithYandex()
    {
        return Socialite::driver('yandex')->redirect();
    }


    public function callbackFromYandex()
    {
        try {
            $user = Socialite::driver('yandex')->user();

            // Check Users Email If Already There
            $is_user = User::where('email', $user->getEmail())->first();
            if (!$is_user) {

                $imgName = "profile-photos/" . str()->random(40) . ".jpg";
                file_put_contents("storage/" . $imgName, file_get_contents($user->getAvatar()));

                $saveUser = User::updateOrCreate([
                    'yandex_id' => $user->getId(),
                ], [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getName() . '@' . $user->getId()),
                    'profile_photo_path' => $imgName,
                    'id_role' => 3,
                ]);
            } else {
                $saveUser = User::where('email', $user->getEmail())->update([
                    'yandex_id' => $user->getId(),
                ]);
                $saveUser = User::where('email', $user->getEmail())->first();
            }


            Auth::loginUsingId($saveUser->id);
            return redirect('/');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
