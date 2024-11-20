<?php

use App\Http\Controllers\aDMAlphaController;
use App\Http\Controllers\aDMKompenController;
use App\Http\Controllers\aDTAdminController;
use App\Http\Controllers\aDTDosenController;
use App\Http\Controllers\aDTTenknisiController;
use App\Http\Controllers\AlphaController;
use App\Http\Controllers\aManageBidKomController;
use App\Http\Controllers\aManageDaMaKomController;
use App\Http\Controllers\aManageKompenController;
use App\Http\Controllers\aUpdateKompenController;
use App\Http\Controllers\aUserADTController;
use App\Http\Controllers\aUserMahasiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\aWelcomeController;
use App\Http\Controllers\dtDMAlphaController;
use App\Http\Controllers\dtDMKompenController;
use App\Http\Controllers\dtManageKompenController;
use App\Http\Controllers\dtUpdateKompenController;
use App\Http\Controllers\dtWelcomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LihatPilihKompenController;
use App\Http\Controllers\UpdateKompenSelesaiController;
use App\Http\Controllers\UpdateProgresTugasKompenController;
use App\Http\Controllers\WelcomeController;
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

// Landing Page
Route::get('/', [LandingPageController::class, 'index']);

// Login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

// Logout
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

// Welcome for Mahasiswa
Route::get('/Mahasiswa', [WelcomeController::class, 'index']);

// Welcome for Admin
Route::get('/Admin', [aWelcomeController::class, 'index']);

// Welcome for Dosen/Teknisi
Route::get('/DosenTeknisi', [dtWelcomeController::class, 'index']);

// user as Mahasiswa
// Lihat dan Pilih Kompen
Route::get('/mLihatPilihKompen', [LihatPilihKompenController::class, 'index']);

// Update Progres Tugas Kompen
Route::get('/mUpdateProgresTugasKompen', [UpdateProgresTugasKompenController::class, 'index']);

// Update Kompen Selesai
Route::get('/mUpdateKompenSelesai', [UpdateKompenSelesaiController::class, 'index']);

// user as Admin
// Level User
// Route::get('/level', [LevelController::class, 'index'])->name('level.index');


Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::post('/list', [LevelController::class, 'list'])->name('level.list');
    Route::get('/create', [LevelController::class, 'create'])->name('level.create');
    Route::post('/', [LevelController::class, 'store'])->name('level.store');
    Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
    Route::post('/ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
Route::put('level/{level_id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
//Route::get('level/{id}/show_ajax', [LevelController::class, 'show_ajax'])->name('level.show_ajax');
Route::put('/{id}', [LevelController::class, 'show'])->name('level.show');
    Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
    Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.delete_ajax');
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax_confirm');
    Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
});



// User Admin/Dosen/Teknisi
//Route::get('/aAdminDosenTeknisi', [aUserADTController::class, 'index']);

Route::group(['prefix' => 'aAdminDosenTeknisi'], function () {
    Route::get('/', [aUserADTController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [aUserADTController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [aUserADTController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [aUserADTController::class, 'store']);         // menyimpan data user baru
    Route::get('/aUserADT/create_ajax', [aUserADTController::class, 'create_ajax'])->name('user.create_ajax');
    //Route::get('/create_ajax', [aUserADTController::class, 'create_ajax']);   // menampilkan halaman form tambah user
    Route::post('/user/store_ajax', [aUserADTController::class, 'store_ajax'])->name('user.store_ajax');

    //Route::post('/ajax', [aUserADTController::class, 'store_ajax']);         // menyimpan data user baru
    Route::get('/{id}/show_ajax', [aUserADTController::class, 'show_ajax']);
    Route::get('/{id}', [aUserADTController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [aUserADTController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [aUserADTController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [aUserADTController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
    Route::put('/{id}/update_ajax', [aUserADTController::class, 'update_ajax']); // menyimpan perubahan data user ajax
    Route::get('/{id}/delete_ajax', [aUserADTController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax', [aUserADTController::class, 'delete_ajax']); // untuk hapus data user ajax
    // Route::get('/import', [aUserADTController::class, 'import']); //ajax form upload excel
    // Route::post('/import_ajax', [UserController::class, 'import_ajax']); //ajax form upload excel
    // Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
    // Route::get('/export_pdf', [UserController::class, 'export_pdf']); //export excel
    // Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

// User Mahasiswa
//Route::get('/aMahasiswa', [aUserMahasiswaController::class, 'index']);

Route::group(['prefix' => 'aMahasiswa'], function () {
    Route::get('/', [aUserMahasiswaController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [aUserMahasiswaController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [aUserMahasiswaController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [aUserMahasiswaController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [aUserMahasiswaController::class, 'create_ajax']);   // menampilkan halaman form tambah user
    Route::post('/ajax', [aUserMahasiswaController::class, 'store_ajax']);         // menyimpan data user baru
    Route::get('/{id}/show_ajax', [aUserMahasiswaController::class, 'show_ajax']);
    Route::get('/{id}', [aUserMahasiswaController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [aUserMahasiswaController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [aUserMahasiswaController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [aUserMahasiswaController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
    Route::put('/{id}/update_ajax', [aUserMahasiswaController::class, 'update_ajax']); // menyimpan perubahan data user ajax
    Route::get('/{id}/delete_ajax', [aUserMahasiswaController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax', [aUserMahasiswaController::class, 'delete_ajax']); // untuk hapus data user ajax
    // Route::get('/import', [aUserADTController::class, 'import']); //ajax form upload excel
    // Route::post('/import_ajax', [UserController::class, 'import_ajax']); //ajax form upload excel
    // Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
    // Route::get('/export_pdf', [UserController::class, 'export_pdf']); //export excel
    // Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

// Daftar Mahasiswa Alpha
// Route::get('/aDaftarMahasiswaAlpha', [aDMAlphaController::class, 'index']);
Route::group(['prefix' => 'aDaftarMahasiswaAlpha'], function () {
    Route::get('/', [aDMAlphaController::class, 'index'])->name('aDMAlpha.index'); // Halaman utama
    Route::get('/list', [aDMAlphaController::class, 'list'])->name('aDMAlpha.list'); // Data untuk DataTables
});


// Daftar Mahasiswa Kompen
Route::get('/aDaftarMahasiswaKompen', [aDMKompenController::class, 'index']);

// Daftar Tugas Dosen
Route::get('/aDaftarTugasDosen', [aDTDosenController::class, 'index']);

// Daftar Tugas Teknisi
Route::get('/aDaftarTugasTeknisi', [aDTTenknisiController::class, 'index']);

// Daftar Tugas Admin
Route::get('/aDaftarTugasAdmin', [aDTAdminController::class, 'index']);

// Manage Bidang Kompetensi
//Route::get('/aManageBidangKompetensi', [aManageBidKomController::class, 'index']);

Route::group(['prefix' => 'aManageBidangKompetensi'], function () {
    Route::get('/', [aManageBidKomController::class, 'index'])->name('bidangKompetensi.index');
    Route::post('/list', [aManageBidKomController::class, 'list'])->name('bidangKompetensi.list');
    Route::get('/create_ajax', [aManageBidKomController::class, 'create_ajax'])->name('bidangKompetensi.create_ajax');
    Route::post('/ajax', [aManageBidKomController::class, 'store_ajax'])->name('bidangKompetensi.store_ajax');
    Route::get('/{id}/edit_ajax', [aManageBidKomController::class, 'edit_ajax'])->name('bidangKompetensi.edit_ajax');
    Route::put('/{id}/update_ajax', [aManageBidKomController::class, 'update_ajax'])->name('bidangKompetensi.update_ajax');
    Route::get('/{id}/show_ajax', [aManageBidKomController::class, 'show_ajax'])->name('bidangKompetensi.show_ajax');
    
    // Perbaiki route delete_ajax
    Route::get('/delete_ajax/{id}', [aManageBidKomController::class, 'delete_ajax'])->name('bidangKompetensi.delete_ajax');
    Route::delete('/destroy/{id}', [aManageBidKomController::class, 'destroy'])->name('bidangKompetensi.destroy');
    Route::get('/confirm_ajax/{id}', [aManageBidKomController::class, 'confirm_ajax'])->name('bidangKompetensi.confirm_ajax');
});

// Manage Data Mahasiswa Kompen
Route::get('/aManageDataMahasiswaKompen', [aManageDaMaKomController::class, 'index']);

// Manage Kompen
Route::get('/aManageKompen', [aManageKompenController::class, 'index']);

// Update Kompen Selesai
Route::get('/aUpdateKompenSelesai', [aUpdateKompenController::class, 'index']);

// User as Dosen/Teknisi
// Daftar Mahasiswa Alpha
Route::get('/dtDaftarMahasiswaAlpha', [dtDMAlphaController::class, 'index']);

// Daftar Mahasiswa Kompen
Route::get('/dtDaftarMahasiswaKompen', [dtDMKompenController::class, 'index']);

// Manage Kompen
Route::get('/dtManageKompen', [dtManageKompenController::class, 'index']);

// Update Kompen
Route::get('/dtUpdateKompen', [dtUpdateKompenController::class, 'index']);