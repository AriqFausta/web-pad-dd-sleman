<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\LoginController;

//web compro

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/galeri/{nama}', [GaleriController::class, 'show'])->name('galeri.show');
Route::get('/Organisasi', [OrganisasiController::class, 'index'])->name('Organisasi.index');
Route::get('/Berita', [BeritaController::class, 'index'])->name('Berita.index');
Route::get('/Berita/Search', [BeritaController::class, 'index'])->name('Berita.search');
Route::get('/Berita/{id}', [BeritaController::class, 'show'])->name('Berita.show');

Route::post('/subscribe', [EmailController::class, 'subscribe'])->name('subscribe');

// admin

Route::get('/admin', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');



// Halaman Dashboard Admin


Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::get('/email-berlangganan', [EmailController::class, 'showEmailBerlangganan'])->name('admin.email_berlangganan');
    Route::delete('/email-berlangganan/{id}', [EmailController::class, 'deleteEmail'])->name('admin.delete_email');
    Route::get('/kirim-informasi', [EmailController::class, 'showKirimInformasi'])->name('admin.kirim_informasi');
    Route::post('/kirim-informasi', [EmailController::class, 'sendBroadcast'])->name('admin.send_broadcast');

    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('admin.index');

    Route::get('/kelola-konten', [KontenController::class, 'showKonten'])->name('admin.kelola_konten');
    Route::put('/kelola-konten/{id}', [KontenController::class, 'updateKonten'])->name('admin.update_konten');

    Route::get('/kelola-galeri', [GaleriController::class, 'showadmin'])->name('admin.kelola_galeri');
    Route::post('/kelola-galeri', [GaleriController::class, 'createGaleri'])->name('admin.create_galeri');
    Route::put('/kelola-galeri/{id}', [GaleriController::class, 'updateGaleri'])->name('admin.update_galeri');
    Route::delete('/kelola-galeri/{id}', [GaleriController::class, 'deleteGaleri'])->name('admin.delete_galeri');

    Route::get('/kelola-organisasi', [OrganisasiController::class, 'showadmmin'])->name('admin.kelola_organisasi');
    Route::put('/kelola-organisasi/mindmap/{id}', [OrganisasiController::class, 'updateMindMap'])->name('admin.update_mindmap');
    Route::put('/kelola-organisasi/deskripsi/{id}', [OrganisasiController::class, 'updateDeskripsi'])->name('admin.update_deskripsi');
    Route::post('/kelola-organisasi/anggota', [OrganisasiController::class, 'createAnggota'])->name('admin.create_anggota');
    Route::put('/kelola-organisasi/anggota/{id}', [OrganisasiController::class, 'updateAnggota'])->name('admin.update_anggota');
    Route::delete('/kelola-organisasi/anggota/{id}', [OrganisasiController::class, 'deleteAnggota'])->name('admin.delete_anggota');

    Route::get('/kelola-berita', [BeritaController::class, 'showAdmin'])->name('admin.kelola_berita');
    Route::post('/kelola-berita', [BeritaController::class, 'createBerita'])->name('admin.create_berita');
    Route::put('/kelola-berita/{id}', [BeritaController::class, 'updateBerita'])->name('admin.update_berita');
    Route::delete('/kelola-berita/{id}', [BeritaController::class, 'deleteBerita'])->name('admin.delete_berita');
    Route::post('/kelola-berita/{id}/toggle-pin', [BeritaController::class, 'togglePin'])->name('admin.toggle_pin_berita');

});
