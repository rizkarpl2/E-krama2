<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Middleware\JWTFundamental;
use Illuminate\Support\Facades\Auth;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/getuser', [AuthController::class, 'index']);
});

Route::middleware('jwtfun')->group(function() {
    Route::get('/getrole', [RoleController::class, 'index']); // Mendapatkan daftar semua peran
    Route::post('/createrole', [RoleController::class, 'store']); // Membuat peran baru
    Route::get('/detailrole/{id}', [RoleController::class, 'show']); // Mendapatkan detail peran berdasarkan ID
    Route::put('/editrole/{id}', [RoleController::class, 'update']); // Memperbarui informasi peran berdasarkan ID
    Route::delete('/deleterole/{id}', [RoleController::class, 'destroy']); // Menghapus peran berdasarkan ID

    Route::get('/getdokumen', [FileUploadController::class, 'index']);
    Route::post('/dokumen/upload', [FileUploadController::class, 'uploadDokumen']);
    Route::get('/dokumen/{id}/download', [FileUploadController::class, 'downloadDokumen']);
    Route::get('/showdokumen/{id}', [FileUploadController::class, 'showdokumen']);
    Route::post('/updatedokumen/{id}', [FileUploadController::class, 'updatedokumen']); // Memperbarui informasi peran berdasarkan ID
    Route::delete('/destroydokumen/{id}', [FileUploadController::class, 'destroy']); // perbarui nama aksi menjadi 'destroy'

   Route::get('/getdivisi', [DivisiController::class, 'index']);
   Route::post('/createdivisi', [DivisiController::class, 'store']); // Membuat peran baru
   Route::get('divisi/{id}', [DivisiController::class, 'show']); // Mendapatkan detail peran berdasarkan ID
   Route::put('updatedivisi/{id}', [DivisiController::class, 'updatedivisi']); // Memperbarui informasi peran berdasarkan ID
   Route::delete('/destroydivisi/{id}', [DivisiController::class, 'destroydivisi']); // perbarui nama aksi menjadi 'destroy'

   //Jabatan
   Route::get('/get-jabatan', [JabatanController::class, 'index']);
   Route::post('/create-jabatan', [JabatanController::class, 'store']); // Membuat peran baru
   Route::get('/detail-jabatan/{id}', [JabatanController::class, 'show']); // Mendapatkan detail peran berdasarkan ID
   Route::put('/update-jabatan/{id}', [JabatanController::class, 'update']); // Memperbarui informasi peran berdasarkan ID
   Route::delete('/destroy-jabatan/{id}', [JabatanController::class, 'destroy']); // perbarui nama aksi menjadi 'destroy'


   

    Route::get('/getkasmasuk', [KasMasukController::class, 'index']);
    Route::post('/kasmasuk', [KasMasukController::class, 'store']);
    Route::get('kasmasuk/{id}', [KasMasukController::class, 'show']); // Mendapatkan detail peran berdasarkan ID
    Route::put('updatekasmasuk/{id}', [KasMasukController::class, 'update']); // Memperbarui informasi peran berdasarkan ID
    Route::delete('/destroykasmasuk/{id}', [KasMasukController::class, 'destroy']); // perbarui nama aksi menjadi 'destroy'


   

   Route::get('/getkaskeluar', [KasKeluarController::class, 'index']);
   Route::post('/createkaskeluar', [KasKeluarController::class, 'store']);
    Route::get('/kaskeluar/{id}', [KasKeluarController::class, 'show']); // Mendapatkan detail peran berdasarkan ID
    Route::put('/updatekaskeluar/{id}', [KasKeluarController::class, 'update']); // Memperbarui informasi peran berdasarkan ID
    Route::delete('/destroykaskeluar/{id}', [KasKeluarController::class, 'destroy']); // perbarui nama aksi menjadi 'destroy'
});