<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/main', '/');
Route::get('/', [\App\Http\Controllers\Main\MainController::class, 'index']);
Route::get('/about_us', [\App\Http\Controllers\About_us\AboutUsController::class, 'index']);
Route::get('/users', [\App\Http\Controllers\Users\UsersController::class, 'index']);
Route::get('/robots', [\App\Http\Controllers\Robots\RobotsController::class, 'index']);
Route::get('/teams', [\App\Http\Controllers\Teams\TeamsController::class, 'index']);
Route::get('/games', [\App\Http\Controllers\Games\GamesController::class, 'index']);
Route::get('/game/{id_game}', [\App\Http\Controllers\Games\Game\GameController::class, 'index']);
Route::get('/game/{id_game}/counter', [\App\Http\Controllers\Games\Game\CounterController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/tournaments', [\App\Http\Controllers\Games\MyTournaments\MyTournamentsController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/tournaments/submit/{id_tournament}/{id_team}', [\App\Http\Controllers\Games\MyTournaments\MyTournamentsController::class, 'submit']);

Route::get('/statistic', [\App\Http\Controllers\Games\Statistics\StatisticsController::class, 'index']);


Route::get('/places', [\App\Http\Controllers\Places\PlacesController::class, 'index']);
Route::get('places/{id_place}', [\App\Http\Controllers\Places\Place\PlaceController::class, 'index']);

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});

/*Route::get('/places/{id_place}/teams', [\App\Http\Controllers\Teams\TeamsController::class, 'index']);*/

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
