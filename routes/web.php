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
Route::get('/admin', [AdminController::class,'index'])->name('admin.index');

Route::resource("ticket",TicketController::class);

