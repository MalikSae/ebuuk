<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminBukuController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPengaturanController;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\BukuPublikController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\RakBukuController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ProfilController;

// PUBLIC
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/buku/{buku:slug}', [BukuPublikController::class, 'show'])->name('buku.show');

// AUTH USER (middleware auth)
Route::middleware('auth')->group(function () {
    Route::get('/baca/{buku:slug}', [ReaderController::class, 'show'])->name('reader.show');
    Route::get('/baca/{buku:slug}/stream', [ReaderController::class, 'stream'])->name('reader.stream');
    Route::post('/baca/{buku:slug}/progress', [ReaderController::class, 'saveProgress'])->name('reader.progress');

    Route::get('/rak-buku', [RakBukuController::class, 'index'])->name('rak-buku.index');
    Route::post('/rak-buku/{buku}', [RakBukuController::class, 'toggle'])->name('rak-buku.toggle');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

require __DIR__.'/auth.php';

// ─── ADMIN ROUTES ───────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kategori
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [AdminKategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');

    // Buku
    Route::get('/buku', [AdminBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [AdminBukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [AdminBukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [AdminBukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [AdminBukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [AdminBukuController::class, 'destroy'])->name('buku.destroy');

    // User
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('user.show');
    Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

    // Pengaturan
    Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/password', [AdminPengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});
