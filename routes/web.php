<?php

use App\Http\Controllers\Admin\AsetController as AdminAsetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\OpdController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KategoriController as ControllersKategoriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\AsetController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', [LandingController::class, 'index']);
Route::get('/kategori/{id}', [ControllersKategoriController::class, 'index']);
Route::get('/kategori/get-aset/{id}', [ControllersKategoriController::class, 'getAset']);
Route::get('/get-aset', [LandingController::class, 'getAset']);
Route::get('/aset-detail/{id}', [AsetController::class, 'asetDetail']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);



Route::middleware(['auth', 'role:admin,opd,verifikator,'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('aset', [AdminAsetController::class, 'index']);
        Route::get('aset-pinjam', [AdminAsetController::class, 'asetPinjam']);
        Route::post('aset', [AdminAsetController::class, 'store']);
        Route::post('aset-update', [AdminAsetController::class, 'update']);
        Route::get('get-aset', [AdminAsetController::class, 'getAset']);
        Route::get('get-aset-by-id/{id}', [AdminAsetController::class, 'getDataAsetbyId']);
        Route::get('get-aset', [AdminAsetController::class, 'getAsetDatatable']);
        Route::get('/get-aset-pinjam-data', [AdminAsetController::class, 'getAsetDatatablePinjam']);
        Route::post('del-aset/{id}', [AdminAsetController::class, 'destroy']);

        Route::get('/permohonan', [PermohonanController::class, 'index']);
        Route::get('/get-permohonan', [PermohonanController::class, 'getAsetDatatable']);

        Route::get('/permohonan_detail/{id}', [PermohonanController::class, 'permohonanDetail']);
        Route::get('/getAsetMohon/{id}', [PermohonanController::class, 'getAsetMohon']);
        Route::get('/getAsetMohonFinish/{id}', [PermohonanController::class, 'getAsetMohonFinish']);
        Route::get('/getDataMohon/{id}', [PermohonanController::class, 'getDataMohon']);
        Route::get('/get-data-mohon-verif/{id}', [PermohonanController::class, 'getAsetMohonVerif']);
        Route::get('/get-data-mohon-reject/{id}', [PermohonanController::class, 'getAsetMohonReject']);
        Route::get('/get-data-mohon-accept/{id}', [PermohonanController::class, 'getAsetMohonAccept']);
        Route::get('/get-data-status/{id}', [PermohonanController::class, 'getDataStatus']);
        Route::post('/accept-aset', [PermohonanController::class, 'update']);
        Route::get('/getDataAsetId/{id}', [PermohonanController::class, 'getDataAsetId']);
        Route::post('/finishAset/{idmohon}', [PermohonanController::class, 'finishAset']);
        //selesai
        Route::get('/permohonan-finish', [PermohonanController::class, 'getAsetMohonFinishAll']);
        Route::get('/permohonan-finish-all-data', [PermohonanController::class, 'getAsetMohonFinishAllData']);

        //verifikasi
        Route::get('/permohonan-verif', [PermohonanController::class, 'getAsetMohonVerifAll']);
        Route::get('/permohonan-verif-all-data', [PermohonanController::class, 'getAsetMohonVerifAllData']);

        //reject
        Route::get('/permohonan-reject', [PermohonanController::class, 'getAsetMohonRejectAll']);
        Route::get('/permohonan-reject-all-data', [PermohonanController::class, 'getAsetMohonRejectAllData']);


        Route::get('/admin-opd', [UserController::class, 'adminOpd']);
        Route::get('/user', [UserController::class, 'user']);
        Route::get('/admin-opd-data', [UserController::class, 'getDatatablesAdminOpd']);
        Route::post('/admin-opd', [UserController::class, 'storeAdminOpd']);
        Route::delete('/admin-opd/{id}', [UserController::class, 'destroy']);

        Route::get('/pass-reset', [SettingController::class, 'passReset']);
        Route::post('/pass-reset', [SettingController::class, 'updateConfigPass']);
    });
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/user-data', [UserController::class, 'getDatatablesUser']);
        Route::put('/user/{id}/{status}', [UserController::class, 'updateStatus']);
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::get('/kategori-data', [KategoriController::class, 'getDatatablesKategori']);
        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::post('/kategori-delete/{id}', [KategoriController::class, 'destroy']);
        Route::post('/kategori-edit', [KategoriController::class, 'update']);
        Route::get('/opd', [OpdController::class, 'index']);
        Route::get('/opd-data', [OpdController::class, 'getDatatablesOpd']);
        Route::post('/opd', [OpdController::class, 'store']);
        Route::post('/opd-delete/{id}', [OpdController::class, 'destroy']);
        Route::get('/app', [SettingController::class, 'app']);
        Route::post('/setting-update', [SettingController::class, 'updateConfig']);
        Route::post('/setting-update-logo', [SettingController::class, 'updateLogo']);
    });
});

Route::group(['middleware' => ['auth', 'role:pengguna']], function () {
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index']);
        Route::post('/permohonan', [AsetController::class, 'store']);
        Route::get('/list_aset', [AsetController::class, 'list_aset']);
    });
});
