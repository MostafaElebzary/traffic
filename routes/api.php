<?php

use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportsController;
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

Route::post('/login', [UserController::class, 'login']);
Route::post('/update-profile', [UserController::class, 'updateProfile']);
Route::get('/states', [UserController::class, 'states']);


Route::get('/get-transaction', [TransactionsController::class, 'transactions']);
Route::post('/add-transaction', [TransactionsController::class, 'AddTransaction']);
Route::post('/edit-transaction', [TransactionsController::class, 'EditTransaction']);
Route::get('/delete-transaction/{id}', [TransactionsController::class, 'deleteTransaction']);




Route::group(['prefix' => 'reports'], function () {
    Route::get('/with_state', [ReportsController::class, 'with_state']);
    Route::get('/without_state', [ReportsController::class, 'without_state']);

});
