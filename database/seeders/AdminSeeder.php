<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Администратор портала",
            'email' => "vania.moroz22@gmail.com",
            "password" => '$2y$10$4.Kn.IoJ09VU5fKXvdDTbeJsqZ/Tpd2KbY9FRUvLUKFbMMUMwE5vC',
            "created_at"=> "2022-02-12 16:06:56",
            "updated_at"=> "2022-02-13 13:22:04",
            "id_role" => 1
        ]);
    }
}
