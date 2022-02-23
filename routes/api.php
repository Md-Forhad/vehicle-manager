<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

//API route for register new user
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
//API route for login user
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function(Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

 Route::get("/vehicle-list", [ApiController::class, "VehicleList"]);
 Route::get("/delete-list", [ApiController::class, "DeleteList"]);
 Route::get("/single-vehicle/{id}", [ApiController::class, "SingleVehicleDetails"]);
 Route::post("/add-vehicle", [ApiController::class, "CreateVehicle"]);
 Route::put("/update-vehicle/{id}", [ApiController::class, "VehicleUpdate"]);
 Route::delete("/delete-vehicle/{id}", [ApiController::class, "VehicleDelete"]);
