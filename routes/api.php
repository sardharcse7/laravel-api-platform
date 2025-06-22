<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware(['auth:api', 'check.api.rate'])->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/data', [ApiController::class, 'getData']);
    Route::get('/usage-summary', [ApiController::class, 'usageSummary']);
    Route::get('/billing-summary', [ApiController::class, 'billingSummary']);
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
