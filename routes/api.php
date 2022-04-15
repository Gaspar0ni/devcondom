<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

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


Route::get('/ping', function(){
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function(){
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //mural de avisos
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    //Documentos
    Route::get('/docs', [DocController:class, 'getAll']);

    //livro de ocorrências
    Route::get('/warnings', [WarningController::class, 'getMyWarnings']);
    Route::post('/warning', [WarningController::class, 'setWarning']);
    Route::post('/warning/file', [WallController::class, 'addWarningFile']);

    //boletos
    Route::post('/billets', [BilletController::class, 'getAll']);

    //Achados e perdidos
    Route:get('/foundandlost', [FoundAndLostController::class, 'getAll']);
    Route:post('/foundandlost', [FoundAndLostController::class, 'insert']);
    Route::put('/foundandlost/{id}', [FoundAndLostController::class, 'update']);

    //unidade-listas de pets, moradores, veiculos...
    Route::get('/unit/{id}', [UnitController::class, 'getInfo']);
    Route::post('/unit{id}/addperson', [UnitController::class, 'addPerson']);
    Route::post('/unit{id}/addvehicles', [UnitController::class, 'addVehicles']);
    Route::post('/unit{id}/addpet', [UnitController::class, 'addPet']);
    Route::post('/unit{id}/removeperson', [UnitController::class, 'removePerson']);
    Route::post('/unit{id}/removevehicles', [UnitController::class, 'removeVehicles']);
    Route::post('/unit{id}/removepet', [UnitController::class, 'removePet']);

    //Reservas
    Route::get('/reservations', [ReservationController::class, 'getReservations']);
    Route::get('/myreservations', [ReservationController::class, 'getMyReservations']);


    Route::get('/reservation/{id}/disabledddates', [ReservationController::class, 'getDisabledDates']);
    Route::get('reservation/{id}', [ReservationController::class, 'getTimes']);

    Route::delete('myreservation/{id}', [ReservationController::class, 'delMyReservation']);
    Route::post('/reservation/{id}', [ReservationController::class, 'setReservation']);
});
