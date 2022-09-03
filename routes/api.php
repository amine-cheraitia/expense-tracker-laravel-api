<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\AuthentificationController;


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
Route::get('/mouvement/kpi/{id}', [MouvementController::class, 'kpi'])/* ->middleware('auth:sanctum') */;
Route::get('/mouvement/user/{id}', [MouvementController::class, 'showUserMouvement'])->middleware('auth:sanctum');
Route::apiResource('/mouvement', MouvementController::class)/* ->middleware('auth:sanctum') */;


Route::apiResource('/ressource', RessourceController::class)->middleware('auth:sanctum');
Route::apiResource('/typeressource', TypeRessourceController::class)->middleware('auth:sanctum');
Route::get('/ressource/user/{id}', [RessourceController::class, 'showperuser'])->middleware('auth:sanctum');
Route::get('/ressourcetotal/user/{id}', [MouvementController::class, 'TotalEntreSortie'])->middleware('auth:sanctum');;

Route::post('/login', [AuthentificationController::class, 'login']);
Route::post('/signup', [AuthentificationController::class, 'create']);
Route::post('/logout', [AuthentificationController::class, 'logout']);
Route::post('/create', [AuthentificationController::class, 'create']);
Route::post('/checktoken', [AuthentificationController::class, 'checkToken'])->middleware('auth:sanctum');;