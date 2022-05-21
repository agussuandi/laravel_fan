<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpresenceController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'epresence'], function ($router) {
    Route::get('/', [EpresenceController::class, 'index'])->name('epresence');
    Route::post('/absenIn', [EpresenceController::class, 'absenIn'])->name('absenIn');
    Route::post('/absenOut', [EpresenceController::class, 'absenOut'])->name('absenOut');
    // Route::put('/approvalAbsen/{id}', [EpresenceController::class, 'approvalAbsen'])->name('approvalAbsen');
});