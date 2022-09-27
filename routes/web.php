<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Database\Factories\ResponseFactory;
use Database\Factories\UserFactory;
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

Route::get('factory',function (){
  ResponseFactory::new()->count(5)->create();
  UserFactory::new()->count(3)->create();
});

Route::get('/home', [HomeController::class,'index'])->name('home');

Route::prefix('/poshtiban')->name('poshtiban.')->group(function (){
    Route::resource('response',ResponseController::class)->only('index')->middleware('Checkposhtiban');
    Route::get('create/{ticket}',[ResponseController::class,'create'])->name('response.create')->middleware('Checkposhtiban');
    Route::post('store/{ticket}',[ResponseController::class,'store'])->name('response.store')->middleware('Checkposhtiban');
    Route::put('update/{ticket}',[ResponseController::class,'update'])->name('response.update')->middleware('Checkposhtiban');
});

Route::prefix('admin')->group(function(){
    Route::get('/', [AdminController::class,'index'])->name('admin.index');
    Route::get('/create_subject', [AdminController::class,'create_subject'])->name('admin.create.subject');
    Route::post('/store_subject/{user}', [AdminController::class,'store_subject'])->name('admin.store.subject');
    Route::get('/edit_subject/{ticket}', [AdminController::class,'edit_subject'])->name('admin.edit.subject');
    Route::put('/update_subject/{ticket}/{user}', [AdminController::class,'update_subject'])->name('admin.update.subject');
    Route::delete('/destroy_subject/{subject}', [AdminController::class,'destroy_subject'])->name('admin.destroy.subject');
    Route::get('/create_user', [UserController::class,'create_user'])->name('admin.create.user');
    Route::post('/store_user', [UserController::class,'store_user'])->name('admin.store.user');
    Route::get('/edit_user/{user}', [UserController::class,'edit_user'])->name('admin.edit.user');
    Route::put('/update_user/{uuser}', [UserController::class,'update_user'])->name('admin.update.user');
});

Route::resource("ticket",TicketController::class)->except(['show','edit','update','destroy'])->middleware('Checkuser');


Route::prefix('/admin')->name('admin.')->group(function (){
    Route::resource("ticket",TicketController::class)->only(['show','edit','update','destroy'])->middleware('Checkadmin');
});

