<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\vendor\vendorAuthController;
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

// create and signin vendor
Route::post('vendor/signin', [vendorAuthController::class, 'signin'])->name('vendorlogin');
Route::post('vendor/register', [vendorAuthController::class, 'Register'])->name('vendorregistration');
// End create and signin driver
