<?php

namespace Tests\Feature;

use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Tests\TestCase;
use function Livewire\str;

/**
 * Class UploadTest
 * @package Tests\Feature
 * Тестирует выгрузку и сохранение файлов
 * Внимание! Некоторые пути к файлам актуальны лишь для запуска тестов
 * В самом приложении придется использовать пути вида, как в методах класса App\Http\Livewire\Forms\RobotForm
 */
class UploadTest extends TestCase
{
    use WithFileUploads;
    public function test_save_photo()
    {
        $path = "storage/app/public";
        $hash = str()->random(30);
        $name = str()->random(4);
        copy("$path/ru.jpg", "$path/test-images/ru.jpg");
        $this->assertFileExists(storage_path("app/public/test-images/ru.jpg"));
    }
    public function test_save_and_move_photo()
    {
        $path = "storage/app/public";
        $hash = str()->random(30);
        $name = str()->random(4);
        copy("$path/ru.jpg", "$path/livewire-tmp/$hash-meta" . base64_encode($name) . "-.jpg");
        $photo = TemporaryUploadedFile::createFromLivewire("$hash-meta" . base64_encode($name) . "-.jpg");
        $photo->storeAs("test-images/", $photo->getClientOriginalName().".jpg");
        $this->assertFileExists(storage_path("app/public/test-images/".$photo->getClientOriginalName().".jpg"));
    }
}
