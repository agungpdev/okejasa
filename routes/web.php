<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Pengaturan\MenuManagemen;
use App\Http\Controllers\Pengaturan\PermissionManagemen;
use App\Http\Controllers\Pengaturan\RoleManagemen;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Toko\JasaController;
use App\Http\Controllers\Toko\KategoriController;
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

Route::get('/',[AuthenticatedSessionController::class,'create'])->middleware('guest')->name('home');

Route::name('dashboard')->prefix('dashboard')->middleware(['auth','verified'])->group(function(){
    Route::get('/',[DashboardController::class,'index']);
    /**
     * =========== route group kelola toko ===========
     */
    Route::name('toko')->prefix('toko')->group(function(){
        /**
         * =========== route group kategori ===========
         */
        Route::name('kategori')->prefix('kategori')->group(function(){
            Route::name('index')->get('/',[KategoriController::class,'index']);
            Route::name('.store')->post('/store',[KategoriController::class,'store']);
            Route::name('.edit')->get('/edit',[KategoriController::class,'edit']);
            Route::name('.update')->post('/update',[KategoriController::class,'update']);
            Route::name('.delete')->delete('/destroy',[KategoriController::class,'destroy']);
        });
        /**
         * =========== route group jasa ===========
         */
        Route::name('jasa')->prefix('jasa')->group(function(){
            Route::name('index')->get('/',[JasaController::class,'index']);
            Route::name('.store')->post('/store',[JasaController::class,'store']);
            Route::name('.edit')->get('/edit',[JasaController::class,'edit']);
            Route::name('.update')->post('/update',[JasaController::class,'update']);
            Route::name('.delete')->delete('/destroy',[JasaController::class,'destroy']);
        });
    });
    /**
     * =========== route group pengaturan ===========
     */
    Route::name('pengaturan')->prefix('pengaturan')->group(function(){
        /**
         * =========== route group role managemen ===========
         */
        Route::name('role')->prefix('role-managemen')->group(function(){
            Route::name('index')->get('/',[RoleManagemen::class,'index']);
            Route::name('.store')->post('/store',[RoleManagemen::class,'store']);
            /**
             * =========== route group permission ===========
             */
            Route::name('permission')->prefix('permission')->group(function(){
                Route::name('.edit')->get('/edit',[PermissionManagemen::class,'edit']);
                Route::name('.store')->post('/store',[PermissionManagemen::class,'store']);
            });
        });
        /**
         * =========== route group menu managemen ===========
         */
        Route::name('menu')->prefix('menu-managemen')->group(function(){
            Route::name('index')->get('/',[MenuManagemen::class,'index']);
            Route::name('.edit')->get('/edit',[MenuManagemen::class,'edit_menu']);
            Route::name('.store')->post('/store',[MenuManagemen::class,'store']);
            Route::name('.update')->put('/update',[MenuManagemen::class,'update_menu']);
            Route::name('.update-submenu')->put('/update/submenu',[MenuManagemen::class,'update_submenu']);
            Route::name('.store-submenu')->post('/store/submenu',[MenuManagemen::class,'store_submenu']);
            Route::name('.menuactive')->post('/activated/menu',[MenuManagemen::class,'activated_menu']);
            Route::name('.delete')->delete('/destroy',[MenuManagemen::class,'destroy']);
        });
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
