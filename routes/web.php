<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;

use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [PageController::class, 'index']);
Route::get('forecast', [PageController::class, 'forecast']);
Route::get('iklim', [PageController::class, 'iklim']);
Route::get('hama', [PageController::class, 'hama']);
Route::get('katam', [PageController::class, 'katam']);
Route::get('katamPalawija', [PageController::class, 'katamPalawija']);
Route::get('prediksi', [PageController::class, 'prediksi']);
Route::get('cuaca', [PageController::class, 'cuaca']);

Route::get('getWindmap', [DataController::class, 'getWindmap']);
Route::get('getForecast', [DataController::class, 'getForecast']);
Route::get('getHama', [DataController::class, 'getHama']);
Route::get('getKatam', [DataController::class, 'getKatam']);
Route::get('getKatamPalawija', [DataController::class, 'getKatamPalawija']);
Route::get('getVillageForecast', [DataController::class, 'getVillageForecast']);
Route::get('getVillageKatam', [DataController::class, 'getVillageKatam']);
Route::get('getVillageHama', [DataController::class, 'getVillageHama']);
Route::get('getVillageKatamPalawija', [DataController::class, 'getVillageKatamPalawija']);

require __DIR__.'/auth.php';