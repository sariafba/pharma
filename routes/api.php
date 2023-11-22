<?php

use App\Http\Controllers\StatusMedicineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




// unprotected
Route::post('/register', [USerController::class,'register']);
Route::post('/login', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout']);


//medicine
Route::controller(MedicineController::class)->prefix('medicine')
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/search/{name}', 'search');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/update/{id}', 'update');
        Route::post('/create', 'store');
});


//test
Route::get('test', [StatusMedicineController::class, 'index']);


















//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
