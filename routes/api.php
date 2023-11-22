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
