<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\TypeRessourceController;

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


Route::apiResource('/mouvement', MouvementController::class);
Route::apiResource('/ressource', RessourceController::class);
Route::apiResource('/typeressource', TypeRessourceController::class);
Route::get('/ressource/user/{id}', [RessourceController::class, 'showperuser']);
Route::get('/ressourcetotal/user/{id}', [MouvementController::class, 'TotalEntreSortie']);

Route::post('/login', [AuthentificationController::class, 'login']);
Route::post('/logout', [AuthentificationController::class, 'logout']);
Route::post('/create', [AuthentificationController::class, 'create']);