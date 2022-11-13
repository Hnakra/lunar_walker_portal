<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SendFeedback extends Component
{
    // переменные формы
    public $name, $email, $question;
    // переменные отображения
    public $message = "";
    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'question' => 'required'
    ];
    protected $messages = [
        'name.required' => "Заполните поле Имя", 'name.min' => "Ваше Имя не должно содержать менее 2 символов!",
        'email.required' => "Заполните поле Электронной почты", 'email.email' => "Укажите существующий адрес электронной почты",
        'question.required' => 'Текст обращения не должен быть пустым'
    ];
    public function send(){
        $this->validate();
        $data = [
            "name" => $this->name,
            "email" => $this->email,
            "question" => $this->question,
        ];
        Mail::to('vania.moroz22@gmail.com')->send(new \App\Mail\SendFeedback($data));
        $this->question = "";
        $this->message = "Заявка отправлена! В близжайшее время с Вами свяжутся.";
    }
    public function render()
    {
        return view('livewire.send-feedback');
    }
}
