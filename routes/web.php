<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;

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

Route::get('/', [Controller::class, 'index'])->name('login');

Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);

Route::get('/dashboard', [Controller::class, 'dashboard'])->middleware('auth')->name('dashboard');
//Notes
Route::get('/note/{note}', [NoteController::class, 'show'])->middleware('auth')->name('note');
Route::put('/note/{note}', [NoteController::class, 'update'])->middleware('auth');
Route::delete('/note/{note}', [NoteController::class, 'destroy'])->middleware('auth');
Route::post('/note', [NoteController::class, 'store'])->middleware('auth');
