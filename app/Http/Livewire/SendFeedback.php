<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

/**
 * Class SendFeedback, форма обратной связи
 * @package App\Http\Livewire
 */
class SendFeedback extends Component
{
    // переменные формы
    public $name, $email, $question;
    // переменные отображения
    public $message = "";
    // Настройка правил валидации для формы
    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'question' => 'required'
    ];
    // Настройка правил сообщений для формы
    protected function getMessages() {
        return [
            'name.required' => __("Заполните поле Имя"), 'name.min' => __("Ваше Имя не должно содержать менее 2 символов!"),
            'email.required' => __("Заполните поле Электронной почты"), 'email.email' => __("Укажите существующий адрес электронной почты"),
            'question.required' => __('Текст обращения не должен быть пустым')
        ];
    }
    // метод отправки письма администратору портала
    public function send(){
        $this->validate($this->rules, $this->getMessages());
        $data = [
            "name" => $this->name,
            "email" => $this->email,
            "question" => $this->question,
        ];
        Mail::to('vania.moroz22@gmail.com')->send(new \App\Mail\SendFeedback($data));
        $this->question = "";
        $this->message = __("Заявка отправлена! В близжайшее время с Вами свяжутся.");
    }
    public function render()
    {
        return view('livewire.send-feedback');
    }
}
