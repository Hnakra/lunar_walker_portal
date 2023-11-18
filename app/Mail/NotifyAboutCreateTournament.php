<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NotifyAboutCreateTournament, класс уведомления игрока по email о созданном турнире
 * @package App\Mail
 */
class NotifyAboutCreateTournament extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notify_about_create_tournament')
            ->subject(__('Уведомление о начале турнира'))
            ->from('test349i49534594958@gmail.com', __('Посыльный Робофутбола'))
            ->with('data', $this->data);
    }
}
