<?php

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',['uses' => 'App\Http\Controllers\Api\Auth\RegisterController@__invoke']);

//Роуты для аутентификации
Route::group(['namespace' => 'Api'], function () {
Route::group(['namespace' => 'Auth'], function () {
    Route::post('/register', [RegisterController::class, '__invoke']);
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/logout', [LogoutController::class, '__invoke']);
    });
});

Route::middleware('auth:api')->group(function ()
{
//Роуты для листов с задачами
Route::get('/List/{id}', [ListsController::class, 'listByID']);

Route::post('/List', [ListsController::class, 'addList']);

Route::post('/List/Mark/{id}', [ListsController::class, 'markIsOpen']);

Route::put('/List/{id}', [ListsController::class, 'listEdit']);

Route::delete('/List/{id}', [ListsController::class, 'listDelete']);

//Роуты для задач
Route::get('/Task/{id}', [TasksController::class, 'taskByID']);

Route::post('/Task', [TasksController::class, 'addTask']);

Route::post('/Task/Mark/{id}', [TasksController::class, 'mark']);

Route::put('/Task/{id}', [TasksController::class, 'taskEdit']);

Route::delete('/Task/{id}', [TasksController::class, 'taskDelete']);
});
