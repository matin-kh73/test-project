<?php

use App\Http\Controllers\API\V1\SMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('send-async-message', [SMSController::class, 'sendAsyncMessage']);
    Route::post('send-sync-message', [SMSController::class, 'sendSyncMessage']);
    Route::get('messages', [SMSController::class, 'messages']);
});
