<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});



// Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard routes
            Route::controller(App\Http\Controllers\Admin\DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function () {
                Route::get('/', 'dashboard')->name('index');
            });
        // Dashboard routes


        // Profile routes
            Route::controller(App\Http\Controllers\Admin\ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/{user}', 'update')->name('update');
            });
        // Profile routes


        // Users routes
            Route::controller(App\Http\Controllers\Admin\UserController::class)->prefix('users')->name('users.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{user}', 'edit')->name('edit');
                Route::post('/update/{user}', 'update')->name('update');
                Route::get('/delete/{user}', 'delete')->name('delete');
                Route::post('/', 'filter')->name('filter');
            });
        // Users routes


        // Brands routes
            Route::controller(App\Http\Controllers\Admin\BrandController::class)->prefix('brands')->name('brands.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{brand}', 'edit')->name('edit');
                Route::post('/update/{brand}', 'update')->name('update');
                Route::get('/delete/{brand}', 'delete')->name('delete');
            });
        // Brands routes


        // Categories routes
            Route::controller(App\Http\Controllers\Admin\CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{category}', 'edit')->name('edit');
                Route::post('/update/{category}', 'update')->name('update');
                Route::get('/delete/{category}', 'delete')->name('delete');
            });
        // Categories routes


        // Products routes
            Route::controller(App\Http\Controllers\Admin\ProductController::class)->prefix('products')->name('products.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{product}', 'edit')->name('edit');
                Route::post('/update/{product}', 'update')->name('update');
                Route::get('/delete/{product}', 'delete')->name('delete');
            });
        // Products routes


        // Purchases routes
            Route::controller(App\Http\Controllers\Admin\PurchaseController::class)->prefix('purchases')->name('purchases.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{purchase}', 'edit')->name('edit');
                Route::post('/update/{purchase}', 'update')->name('update');
                Route::get('/delete/{purchase}', 'delete')->name('delete');

                Route::post('/', 'filter')->name('filter');
                Route::get('/download', 'download')->name('download');
            });
        // Purchases routes


        // Sales routes
            Route::controller(App\Http\Controllers\Admin\SalesController::class)->prefix('sales')->name('sales.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{sale}', 'edit')->name('edit');
                Route::post('/update/{sale}', 'update')->name('update');
                Route::get('/delete/{sale}', 'delete')->name('delete');

                Route::post('/', 'filter')->name('filter');
                Route::get('/download', 'download')->name('download');
            });
        // Sales routes

    });
// Admin routes



require __DIR__.'/auth.php';