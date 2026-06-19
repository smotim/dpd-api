<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DPDController;

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

Route::get('cities', [DPDController::class, 'queryCities'])
    ->name('cities.query');
Route::get('cities/by-dpd-city-id/{dpdCityId}', [DPDController::class, 'getCityByDpdCityId'])
    ->where('dpdCityId', '[0-9]+')
    ->name('cities.show-by-dpd-city-id');
Route::get('cities/{id}', [DPDController::class, 'getCity'])
    ->whereNumber('id')
    ->name('cities.show');