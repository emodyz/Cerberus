<?php

use Emodyz\Cerberus\Http\Controllers\CerberusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
|
 is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('api.cerberus')->prefix('api/cerberus')->middleware('api')->group(function () {
    Route::prefix('authorizations')->name('.authorizations')->group(function () {
        Route::get('/', [CerberusController::class, 'getAuthorizations']);
        Route::get('check/{ability}', [CerberusController::class, 'checkAuthorization'])->name('.check');
    });
});
