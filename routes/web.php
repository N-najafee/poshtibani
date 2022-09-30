<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Database\Factories\ResponseFactory;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
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



Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home')->middleware('auth');

Route::prefix('admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index')->middleware(['auth','CheckAdmin']);
});

Route::resource("ticket",TicketController::class)->middleware('auth');
Route::resource("subject",SubjectController::class)->except('show','index')->middleware('auth');
Route::resource("user",UserController::class)->except('show','destroy')->middleware('auth');

Route::prefix('/response')->middleware('auth')->name('response.')->group(function(){
    Route::get('/',[ResponseController::class,'index'])->name('index');
    Route::get('create/{ticket}',[ResponseController::class,'create'])->name('create');
    Route::post('/{ticket}',[ResponseController::class,'store'])->name('store');
    Route::Put('/{ticket}',[ResponseController::class,'update'])->name('update');
});

