<?php

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

Route::redirect('/', '/about_us');
Route::get('/about_us', [\App\Http\Controllers\AboutUsController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/places', [\App\Http\Controllers\PlacesController::class, 'index']);
Route::get('places/{id_place}', [\App\Http\Controllers\PlaceController::class, 'index']);
Route::get('/places/{id_place}/teams', [\App\Http\Controllers\TeamsController::class, 'index']);

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
