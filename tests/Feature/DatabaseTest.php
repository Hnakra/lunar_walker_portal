<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class DatabaseTest extends TestCase
{

    public function test_user_create()
    {
        $user = User::create([
            'name' => "faker",
            'email' => Str::random(20) . "@random.email",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'id_role' => 3
        ]);
        $this->assertModelExists($user);
    }

    public function test_user_delete()
    {
        $user = User::latest()->first();
        $user->delete();
        $this->assertDeleted($user);
    }
}
