<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoshtibanController;
use App\Http\Controllers\TicketController;
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

//Route::get('/', function () {
//    return view('welcome');
//});



Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');
Route::get('/poshtiban', [PoshtibanController::class,'index'])->name('poshtiban.index');
Route::get('/poshtiban/create_response/{ticket}', [PoshtibanController::class,'create_response'])->name('poshtiban.create.response');
Route::post('/poshtiban/store_response/{ticket}', [PoshtibanController::class,'store_response'])->name('poshtiban.store.response');
Route::put('/poshtiban/change_status/{ticket}', [PoshtibanController::class,'change_status'])->name('poshtiban.change.status');
Route::get('/admin', [AdminController::class,'index'])->name('admin.index');
Route::get('/admin/show/{ticket}', [AdminController::class,'show'])->name('admin.show');
Route::get('/admin/create_subject/{subject}', [AdminController::class,'create_subject'])->name('admin.create.subject');
Route::post('/admin/store/{user}', [AdminController::class,'store'])->name('admin.store');
Route::put('/admin/update_subject/{subject}/{user}', [AdminController::class,'update_subject'])->name('admin.update.subject');
Route::delete('/admin/destroy_subject/{subject}', [AdminController::class,'destroy_subject'])->name('admin.destroy.subject');
Route::get('/admin/edit/{user}', [AdminController::class,'edit'])->name('admin.edit');
Route::put('/admin/update/{uuser}', [AdminController::class,'update'])->name('admin.update');

Route::resource("ticket",TicketController::class);

