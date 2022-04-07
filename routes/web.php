<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\admin\Admin1Controller;
use App\Http\Controllers\superadmin\vendor\vendorController;
use App\Http\Controllers\admin\RequestController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('dashboard', function () {
        return view('superuser.home');
    })->name('superadmin/dashboard');
    Route::get('admin', [Admin1Controller::class, 'index'])->name('superadmin/admin');
    Route::post('adminstore', [Admin1Controller::class, 'store'])->name('superadmin/adminstore');
    Route::get('adminedit/{id}', [Admin1Controller::class, 'edit'])->name('superadmin/adminedit');
    Route::post('adminupdate', [Admin1Controller::class, 'update'])->name('superadmin/adminupdate');
    Route::delete('admindelete', [Admin1Controller::class, 'destroy'])->name('superadmin/admindelete');


    // admin vendor routes
    Route::get('vendor', [vendorController::class, 'index'])->name('superadmin/vendor');
    Route::post('vendorstore', [vendorController::class, 'store'])->name('superadmin/vendorstore');
    Route::get('vendoredit/{id}', [vendorController::class, 'edit'])->name('superadmin/vendoredit');
    Route::post('vendorupdate', [vendorController::class, 'update'])->name('superadmin/vendorupdate');
    Route::delete('vendordelete', [vendorController::class, 'destroy'])->name('superadmin/vendordelete');
});


// for admin routes

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.home');
    })->name('admin/dashboard');
    Route::get('request', [RequestController::class, 'index'])->name('admin/request');
    Route::post('vendorstore', [RequestController::class, 'store'])->name('admin/vendorstore');
    Route::get('vendoredit/{id}', [RequestController::class, 'edit'])->name('admin/vendoredit');
    Route::post('vendorupdate', [RequestController::class, 'update'])->name('admin/vendorupdate');
    Route::get('vendor', [RequestController::class, 'showVendor'])->name('admin/vendor');
    Route::delete('vendordelete', [RequestController::class, 'destroy'])->name('admin/vendordelete');

    // report 

    
});






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';