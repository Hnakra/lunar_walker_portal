<?php

namespace Tests\Feature;

use App\Mail\NotifyAboutCreateTournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QueueTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_adds_mail_to_queue()
    {
        Mail::fake();

        $data = [
            "userName" => "test",
            "teamName" => "test",
            "tournamentName" => "test",
            "placeName" => "test",
            "date_time" => "test"

        ];
        $email = "vania.moroz22@gmail.com";
        Mail::to($email)->queue(new NotifyAboutCreateTournament($data));

        Mail::assertQueued(NotifyAboutCreateTournament::class, function ($mail) use ($email) {
            return $mail->to[0]['address'] === $email;
        });
    }
}
