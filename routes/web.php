<?php

use App\Models\Listing;
use Termwind\Components\Li;
use PhpParser\Node\Expr\List_;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ListingController;

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
//All Listing
Route::get('/', [ListingController::class, 'index']);



//Show create form

Route::get('/listings/create', [ListingController::class,'create'])->middleware('auth');

//Store Listing Data

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//show edit form

Route::get('/listings/{listing}/edit', [ListingController::class,'edit'])->middleware('auth');


//update Listing

Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');


//Delete Listing

Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');




//single Listing

Route::get('/listings/{listing}', [ListingController::class, 'show']);


//Show Register/create form

Route::get('/register', [userController::class,'create'])->middleware('guest');


//Create new User

Route::post('/users', [userController::class,'store']);

//Log user out

Route::post('/logout', [userController::class,'logout'])->middleware('auth');


//Show Login form

Route::get('/login', [userController::class,'login'])->name('login')->middleware('guest');


//Log In user

Route::post('/users/authenticate', [userController::class,'authenticate']);