<?php

namespace Tests\Feature;

use App\Mail\NotifyAboutCreateTournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{

    public function it_processes_jobs_from_the_queue()
    {
        Queue::fake();

        // добавляем задачу в очередь
        Queue::push(function () {
            echo "its my test!";
        });

        // проверяем, что задача добавлена в очередь
        Queue::assertPushed(function ($job) {
            return get_class($job) === 'Illuminate\Queue\CallQueuedClosure';
        });

        // обрабатываем очередь
        Queue::assertPushed(function ($job) {
            $job->handle();
            return true;
        });

        // проверяем, что задача успешно выполнена и удалена из очереди
        Queue::assertNothingPushed();
    }

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
