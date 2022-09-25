<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersAndRobotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => 2,
            'name' => "Иван Титов",
            'email' => "123@gmail.com",
            "password" => Hash::make('password'),
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 3
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'name' => "Михаил Белоозерский",
            'email' => "456@gmail.com",
            "password" => Hash::make('password'),
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 3
        ]);
        DB::table('users')->insert([
            'id' => 4,
            'name' => "Андрей Тихий",
            'email' => "789@gmail.com",
            "password" => Hash::make('password'),
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 3
        ]);
        DB::table('users')->insert([
            'id' => 5,
            'name' => "Николай Анохин",
            'email' => "lmr@gmail.com",
            "password" => Hash::make('password'),
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 3
        ]);
        DB::table('users')->insert([
            'id' => 6,
            'name' => "Ирина Мостовая",
            'email' => "kgblmr@gmail.com",
            "password" => Hash::make('password'),
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 3
        ]);

        for($i = 2; $i <= 6; $i++) {
            DB::table('robots')->insert([
                'name' => "robot-" . Str::random(5),
                'is_working' => 1,
                'id_master' => $i,
                'id_place' => 3,
                "created_at" => "2022-02-12 16:06:56",
                "updated_at" => "2022-02-13 13:22:04",
                'key' => Str::random(5),
                'img' => 'none',
                'notation' => Str::random(8),
            ]);
        }
        DB::table('robots')->insert([
            'name' => "robot-" . Str::random(5),
            'is_working' => 1,
            'id_master' => 5,
            'id_place' => 3,
            "created_at" => "2022-02-12 16:06:56",
            "updated_at" => "2022-02-13 13:22:04",
            'key' => Str::random(5),
            'img' => 'none',
            'notation' => Str::random(8),
        ]);
    }
}
