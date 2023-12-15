<?php

use App\Http\Controllers\api\AdminHospitalController;
use App\Http\Controllers\API\BasicLoginController;
use App\Http\Controllers\api\HospitalBloodController;
use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\HospitalController;
use App\Http\Controllers\api\HospitalUserController;
use App\Http\Controllers\api\DiseaseController;
use App\Http\Controllers\api\EmergencyDonateController;
use App\Http\Controllers\api\EmergencyRequestController;
use App\Http\Controllers\api\MedicineController;
use App\Http\Controllers\api\ReviewController;
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
Route::patch('admin/hospital/approve/{id}', [UsersController::class, 'Approved']);
Route::patch('admin/users/block/{id}', [UsersController::class, 'BlockUser']);
Route::patch('admin/users/{id}/changeToAdmin', [UsersController::class, 'changeRoleToAdmin']);
Route::patch('admin/users/{id}/changeToSuperAdmin', [UsersController::class, 'changeRoleToSuperAdmin']);
Route::patch('admin/users/{id}/changeToDefaultUser', [UsersController::class, 'changeRoleToDefualtUser']);

Route::apiResource('/hospitals', HospitalController::class);

Route::apiResource('/hospitals/admin', AdminHospitalController::class);
Route::patch('/hospital/admin/{id}/changeRole', [AdminHospitalController::class, 'changeRole']);
Route::get('/hospital/{id}/admin/bloods/{type}', [AdminHospitalController::class, 'bloods']);
Route::get('/hospital/employee', [AdminHospitalController::class, 'indexEmployee']);
Route::patch('/hospital/admin/addEmployee/{id}', [AdminHospitalController::class, 'addEmployee']);
Route::patch('/hospital/admin/deleteEmployee/{id}', [AdminHospitalController::class, 'deleteEmployee']);
Route::get('/hospital/employes/search', [AdminHospitalController::class, 'searchByName']);

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
Route::patch('/hospital/request/done/{id}', [HospitalUserController::class, 'requestUserDone']);
Route::get('/hospital/payments', [HospitalUserController::class, 'hospitalPayment']);
Route::patch('/hospital/request/{id}/finished', [HospitalUserController::class, 'hospitalFinishRequest']);
Route::get('/request/search', [HospitalUserController::class, 'search']);

Route::post('/hospital/addBlood', [HospitalBloodController::class, 'addBlood']);
Route::patch('/hospital/payBlood/{id}', [HospitalBloodController::class, 'payBlood']);

Route::apiResource('/diseases', DiseaseController::class);
Route::apiResource('/medicines', MedicineController::class);
Route::get('/hospital/{name}',[HospitalController::class,'searchByName']);
Route::get('/hospital/address/{address}',[HospitalController::class,'searchByaddress']);
Route::get('/hospital/default/address',[HospitalController::class,'getdafaulthospitals']);

Route::post('/reviews', [ReviewController::class, 'store']);

Route::apiResource('/emergency-requests', EmergencyRequestController::class);
Route::get('/emergency-request/history', [EmergencyRequestController::class, 'myRequest']);
Route::patch('/emergency-request/done/{id}', [EmergencyRequestController::class, 'done']);

Route::get('/emergency-donates', [EmergencyDonateController::class, 'index']);
Route::get('/emergency-donates/{id}', [EmergencyDonateController::class, 'show']);
Route::delete('/emergency-donates/{id}', [EmergencyDonateController::class, 'destroy']);
Route::post('/emergency-donates/response/{id}', [EmergencyDonateController::class, 'emergencyDonate']);
Route::get('/emergency-donate/history', [EmergencyDonateController::class, 'history']);


