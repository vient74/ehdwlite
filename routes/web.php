<?php

use App\Http\Controllers\DesaController;
use App\Http\Controllers\HighchartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KpmController;
use App\Http\Controllers\LayananAnakController;
use App\Http\Controllers\LayananCatinController;
use App\Http\Controllers\LayananRemajaPutriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterKkController;
use App\Http\Controllers\MasterSasaranController;
use App\Http\Controllers\PmAnakController;
use App\Http\Controllers\PmCatinController;
use App\Http\Controllers\PmIbuHamilNifasController;
use App\Http\Controllers\PmRemajaPutriController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

 
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('chart', [HighchartController::class, 'index'])->name('home')->middleware('auth');
Route::post('logout', [LoginController::class, 'actionlogout'])->name('logout');

Route::get('/desa/metakk', [DesaController::class, 'metakk'])->name('desa.metakk')->middleware('auth');
Route::get('/desa/showkk/{id}', [DesaController::class, 'showkk'])->name('desa.showkk')->middleware('auth');
Route::get('/desa/showsasaran/{id}', [DesaController::class, 'showsasaran'])->name('desa.showsasaran')->middleware('auth');
Route::get('/desa/listdesa/{id}', [DesaController::class, 'listdesa'])->name('desa.listdesa')->middleware('auth');

// layanan
Route::get('/layanan_anak', [LayananAnakController::class, 'index'])->name('layanananak.index')->middleware('auth');
Route::get('/layanan_anak/show_layanan/{id}', [LayananAnakController::class, 'showLayananIndividu'])->name('layanan_anak.show_layanan')->middleware('auth');
Route::get('/layanan_remaja_putri/show_layanan/{id}', [LayananRemajaPutriController::class, 'showLayananIndividu'])->name('layanan_remaja_putri.show_layanan')->middleware('auth');
Route::get('/layanan_catin/show_layanan/{id}', [LayananCatinController::class, 'showLayananIndividu'])->name('layanan_catin.show_layanan')->middleware('auth');

// penerim manfaat
Route::get('/pmanak', [PmAnakController::class, 'index'])->name('pmanak.index')->middleware('auth');
Route::get('/pmremaja_putri', [PmRemajaPutriController::class, 'index'])->name('pmremaja_putri.index')->middleware('auth');
Route::get('/pmcatin', [PmCatinController::class, 'index'])->name('pmcatin.index')->middleware('auth');
Route::get('/pmibu_hamil', [PmIbuHamilNifasController::class, 'index'])->name('pmibu_hamil.index')->middleware('auth');


Route::middleware(['auth', 'role:acf6f46d-1c53-4e4a-8e35-92fa21e20fc8,3ac13019-aa8b-4c41-9c8e-c0c90cb6bbc0,fa3f2ff4-46d1-4fe9-a7bb-f28fe6cd8b69'])->group(function () {
  
    // Master KK
    Route::get('/masterkk', [MasterKkController::class, 'index'])->name('masterkk.index');
    Route::get('/masterkk/create', [MasterKkController::class, 'create'])->name('masterkk.create');
    Route::get('/masterkk/edit', [MasterKkController::class, 'edit'])->name('masterkk.edit');
    Route::get('/masterkk/inputbykpm', [MasterKkController::class, 'inputByKpm'])->name('masterkk.inputbykpm');

    // Other routes
    Route::get('/mastersasaran', [MasterSasaranController::class, 'index'])->name('mastersasaran.index');
    Route::get('/mastersasaran/inputbykpm', [MasterSasaranController::class, 'inputByKpm'])->name('mastersasaran.inputbykpm');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/editpassword/{id}', [UserController::class, 'editpassword'])->name('user.editpassword');
    Route::put('/user/updatepassword/{id}', [UserController::class, 'updatepassword'])->name('user.updatepassword');
    Route::get('/kpm', [KpmController::class, 'index'])->name('kpm.index');
    Route::get('/kpm/create', [KpmController::class, 'create'])->name('kpm.create');
    Route::get('/kpm/edit/{id}', [KpmController::class, 'edit'])->name('kpm.edit');
    Route::put('/kpm/{id}', [KpmController::class, 'update'])->name('kpm.update');

    Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi.index');
    
    Route::get('/provinsi/create', [ProvinsiController::class, 'create'])->name('provinsi.create');
    Route::post('/provinsi', [ProvinsiController::class, 'store'])->name('provinsi.store');
    Route::get('/provinsi/edit/{id}', [ProvinsiController::class, 'edit'])->name('provinsi.edit');
    Route::put('/provinsi/{id}', [ProvinsiController::class, 'update'])->name('provinsi.update');
    Route::get('/kabupaten', [KabupatenController::class, 'index'])->name('kabupaten.index');
    Route::get('/kabupaten/create', [KabupatenController::class, 'create'])->name('kabupaten.create');
    Route::post('/kabupaten', [KabupatenController::class, 'store'])->name('kabupaten.store');
    Route::get('/kabupaten/edit/{id}', [KabupatenController::class, 'edit'])->name('kabupaten.edit');
    Route::put('/kabupaten/{id}', [KabupatenController::class, 'update'])->name('kabupaten.update');
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::get('/kecamatan/create', [KecamatanController::class, 'create'])->name('kecamatan.create');
    Route::post('/kecamatan', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::get('/kecamatan/edit/{id}', [KecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::put('/kecamatan/{id}', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::get('/desa/autodesa', [DesaController::class, 'autodesa'])->name('desa.autodesa');
    Route::get('/desa', [DesaController::class, 'index'])->name('desa.index');
    Route::get('/desa/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('/desa', [DesaController::class, 'store'])->name('desa.store');
    Route::get('/desa/edit/{id}', [DesaController::class, 'edit'])->name('desa.edit');
    Route::put('/desa/{id}', [DesaController::class, 'update'])->name('desa.update');
});


Route::get('/forbidden', function () { return view('errors.403');  })->name('forbidden');
