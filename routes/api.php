<?php

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


//protected api with tokens
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/medicines/search/{name}', [MedicineController::class,'search']);
    Route::post('/logout', [UserController::class,'logout']);
    Route::delete('/delete/{id}', [MedicineController::class,'destroy']);
    Route::put('/update/{id}', [MedicineController::class,'update']);
    Route::post('/create', [MedicineController::class,'store']);
});
// unprotected
Route::get('/medicines', [MedicineController::class,'index']);
Route::post('/register', [USerController::class,'register']);
Route::post('/login', [UserController::class,'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
