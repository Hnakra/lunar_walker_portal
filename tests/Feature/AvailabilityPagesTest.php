<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Tests\TestCase;

class AvailabilityPagesTest extends TestCase
{
    public function test_availability_page_main()
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_availability_page_users()
    {
        $this->get('/users')->assertStatus(200);
    }

    public function test_availability_page_robots()
    {
        $this->get('/robots')->assertStatus(200);
    }

    public function test_availability_page_places()
    {
        $this->get('/places')->assertStatus(200);
    }

    public function test_availability_page_teams()
    {
        $this->get('/teams')->assertStatus(200);
    }

    public function test_availability_page_games()
    {
        $this->get('/games')->assertStatus(200);
    }

    public function test_availability_page_about_us()
    {
        $this->get('/about_us')->assertStatus(200);
    }

    public function test_availability_page_tournaments()
    {
        $this->actingAs(User::first())->get('/tournaments')->assertStatus(200);
    }

    public function test_availability_page_statistic()
    {
        $this->get('/statistic')->assertStatus(200);
    }

    public function test_availability_page_login()
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_availability_page_register()
    {
        $this->get('/register')->assertStatus(200);
    }

    public function test_availability_page_profile()
    {
        $this->actingAs(User::first())->get('/user/profile')->assertStatus(200);
    }

    public function test_availability_page_profile_without_authorization()
    {
        $this->get('/user/profile')->assertStatus(302);
    }

    public function test_availability_page_game()
    {
        $game = Game::first();
        if (isset($game)) {
            $this->get("/game/$game->id")->assertStatus(200);
        }
    }

    public function test_availability_game_counter()
    {
        $game = Game::first();
        if (isset($game)) {
            $this->actingAs(User::first())->get("/game/$game->id/counter")->assertStatus(200);
        }
    }
}
