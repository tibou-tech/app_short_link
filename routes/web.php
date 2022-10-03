<?php

use App\Http\Controllers\LinkController;
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


Route::get('/', fn () => view('welcome'))->name('welcome');

Route::resource('links', LinkController::class)->only(['store', 'destroy', 'show']);


/*
|-----------------------------------------------------------------------------------------------
| Route bilingual
|-----------------------------------------------------------------------------------------------
*/


Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard')->middleware('auth');

    Route::resource('links', LinkController::class)->only(['index']);
});


/*
|-----------------------------------------------------------------------------------------------
| Auth Route By Laravel Breeze
|-----------------------------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
