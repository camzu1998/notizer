<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteTagController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;

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

//Default login
Route::get('/', [Controller::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'user_auth']);

//Third party login
Route::get('/auth/{provider}', [AuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'third_party_auth']);

//Logout
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
    //Dashboards
    Route::resource('dashboards', DashboardController::class)->except([
        'index', 'create', 'edit'
    ]);

    //Notes
    Route::get('/note/{note}', [NoteController::class, 'show'])->name('note');
    Route::put('/note/{note}', [NoteController::class, 'update']);
    Route::delete('/note/{note}', [NoteController::class, 'destroy']);
    Route::post('/note', [NoteController::class, 'store']);

    //Tags
    Route::get('/tags', [TagController::class, 'index'])->name('tags');
    Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tag');
    Route::put('/tag/{tag}', [TagController::class, 'update']);
    Route::delete('/tag/{tag}', [TagController::class, 'destroy']);
    Route::post('/tag', [TagController::class, 'store']);

    //Note tags
    Route::post('/note_tag/{note}', [NoteTagController::class, 'sync'])->can('update', 'note');
    Route::delete('/note_tag/{note}/{tag}', [NoteTagController::class, 'destroy']);
});
