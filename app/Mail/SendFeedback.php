<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendFeedback, класс отправки администратору по email обратной связи
 * @package App\Mail
 */
class SendFeedback extends Mailable
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
        return $this->view('email.send_feedback')
            ->subject(__('Новое сообщение с портала Робофутбол!'))
            ->from('test349i49534594958@gmail.com', __('Главный робот Робофутбола'))
            ->with('data', $this->data);
    }
}
