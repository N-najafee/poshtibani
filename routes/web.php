<?php

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
Route::get('/poshtiban/create/{ticket}', [PoshtibanController::class,'create'])->name('poshtiban.create');
Route::post('/poshtiban/store/{ticket}', [PoshtibanController::class,'store'])->name('poshtiban.store');

Route::resource("ticket",TicketController::class);

