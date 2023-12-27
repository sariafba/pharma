<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoritMedicineController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\StatusMedicineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;





Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [UserController::class,'logout']);

});
Route::post('/login', [UserController::class,'login']);
Route::post('/register', [USerController::class,'register']);
Route::get('/', [USerController::class,'index']);



//medicine
Route::controller(MedicineController::class)
    ->prefix('medicine')->middleware('auth:sanctum')->group(function (){
        Route::get('/', 'index');
        Route::get('show/{id}', 'show');
        Route::get('/search/{name}', 'search');
        Route::post('/delete/{id}', 'destroy');
        Route::post('/update/{id}', 'update');
        Route::post('/store', 'store');
    });

//StatusMedicine
Route::controller(StatusMedicineController::class)
    ->prefix('status_medicine')->middleware('auth:sanctum')->group(function() {
        Route::post('/store/{id}', 'store');
    });

//category
Route::controller(CategoryController::class)
    ->prefix('category')->middleware('auth:sanctum')->group(function(){
        Route::get('/','index');
        Route::get('show/{id}', 'show');
        Route::get('/search/{name}', 'search');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

//cart
Route::controller(CartController::class)
    ->prefix('cart')->middleware('auth:sanctum')->group(function() {
        Route::post('/store/{id}', 'store');
        Route::get('/show', 'show');

    });

//pharmacist ???
Route::controller(PharmacistController::class)->prefix('pharmacist')
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

//Owner
Route::controller(OwnerController::class)->prefix('owner')->group(function() {
        Route::post('/login', 'login');
    });

Route::controller(FavoritMedicineController::class)
    ->prefix('favourite')->middleware('auth:sanctum') ->group(function (){
        Route::get('/','index');
        Route::post('/add/{id}','store');
        Route::get('/show','show');
        Route::post('/delete/{id}', 'destroy');
    });

//test
Route::get('test', function (){

});
