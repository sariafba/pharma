<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\StatusMedicineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [UserController::class,'logout']);
});

//unprotected
Route::post('/register', [USerController::class,'register']);
Route::post('/login', [UserController::class,'login']);

//medicine
Route::controller(MedicineController::class)->prefix('medicine')->middleware('auth:sanctum')
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/search/{name}', 'search');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/update/{id}', 'update');
        Route::post('/store', 'store');
//        Route::get('/{id}', 'showCategoryMedicines');
    });

//category
Route::controller(CategoryController::class)->prefix('category')
    ->group(function(){
        Route::get('/','index');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::get('/{id}', 'show_category');
    });

//pharmacist
Route::controller(PharmacistController::class)->prefix('pharmacist')
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/search/{name}', 'search');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/update/{id}', 'update');
        Route::post('/create', 'store');
    });

//StatusMedicine
Route::controller(StatusMedicineController::class)->prefix('status_medicine')
    ->group(function() {
        Route::get('/', 'index');
        Route::put('/update/{id}', 'update');
    });

//Owner
Route::controller(OwnerController::class)->prefix('owner')
    ->group(function() {
        Route::post('/login', 'login');
    });

//test
Route::get('test', function (){

});
