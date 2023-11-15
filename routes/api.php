<?php

use App\Http\Controllers\api\AdminHospitalController;
use App\Http\Controllers\API\BasicLoginController;
use App\Http\Controllers\api\HospitalBloodController;
use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\HospitalController;
use App\Http\Controllers\api\HospitalUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/users', UsersController::class);

Route::apiResource('/hospitals', HospitalController::class);

Route::apiResource('/hospitals/admin', AdminHospitalController::class);
Route::patch('/hospital/admin/{user}/changeRole', [AdminHospitalController::class, 'changeRole']);
Route::get('/hospital/{id}/admin/bloods/{type}', [AdminHospitalController::class, 'bloods']);
Route::get('/hospital/employee', [AdminHospitalController::class, 'indexEmployee']);
Route::patch('/hospital/admin/addEmployee', [AdminHospitalController::class, 'addEmployee']);
Route::patch('/hospital/admin/deleteEmployee/{id}', [AdminHospitalController::class, 'deleteEmployee']);

Route::post('/hospital/request/{id}', [HospitalUserController::class, 'requestBloods']);
Route::get('/hospital/donor', [HospitalUserController::class, 'showDonorUser']);
Route::get('/users/requests/all', [HospitalUserController::class, 'showUsersRequest']);
Route::get('/requests/{id}', [HospitalUserController::class, 'showRequest']);
Route::get('/hospitals/requests/all', [HospitalUserController::class, 'showHospitalsRequest']);
Route::get('/hospital/requests', [HospitalUserController::class, 'MyHospitalRequests']);
Route::get('/hospital/users/requests', [HospitalUserController::class, 'MyHospitalUsersRequests']);
Route::get('/user/request', [HospitalUserController::class, 'myUserRequests']);
Route::get('/admin/request', [HospitalUserController::class, 'index']);
Route::post('/user/request', [HospitalUserController::class, 'requestDonate']);
Route::delete('/request/{id}', [HospitalUserController::class, 'destroy']);


Route::post('/hospital/addBlood', [HospitalBloodController::class, 'addBlood']);
