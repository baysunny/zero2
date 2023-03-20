<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MembershipController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/authentication/login', [AuthController::class, 'login']);
Route::post('/authentication/tokenValidation', [AuthController::class, 'tokenValidation']);


    // get all the categories
    Route::get('/categories', [CategoryController::class, 'index']);
    // get the category
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    
    // get all the services
    Route::get('/services', [ServiceController::class, 'index']);
    // get the service
    Route::get('/services/{id}', [ServiceController::class, 'show']);

    // register a membership
    Route::post('/memberships', [MembershipController::class, 'store']);



// PROTECTED ROUTES
Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::get('/authentication/{id}', [AuthController::class, 'show']);    

    Route::put('/authentication/{id}', [AuthController::class, 'update']);

    Route::post('/authentication/logout', [AuthController::class, 'logout']);
    

    
    
    // add a new service
    Route::post('/services', [ServiceController::class, 'store']);

    // edit a service
    Route::put('/services/{id}', [ServiceController::class, 'update']);

    // delete a service
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);


    // add a new categorie
    Route::post('/categories', [CategoryController::class, 'store']);

    // edit a categorie
    Route::put('/categories/{id}', [CategoryController::class, 'update']);

    // delete a categorie
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);


    // get all the memberships
    Route::get('/memberships', [MembershipController::class, 'index']);

    // delete a membership
    Route::delete('/memberships/{id}', [MembershipController::class, 'destroy']);
});





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
