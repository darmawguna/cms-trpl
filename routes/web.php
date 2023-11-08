<?php

use App\Http\Controllers\ShowBerita;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\DashboardBeritaController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/berita/checkSlug', [DashboardPostController::class, 'checkSlug']);


// Route::put('/dashboard/berita/{berita:slug}', [DashboardPostController::class, 'update'])->name('berita.destroy');
// Route::delete('/dashboard/berita/{berita:slug}', [DashboardPostController::class, 'destroy'])->name('berita.destroy');
// Route::get('/dashboard/berita/{berita:slug}/edit', [DashboardPostController::class, 'edit'])->name('berita.edit');
Route::resource('/dashboard/berita', DashboardPostController::class)->names([
    'index' => 'berita.index',
    'create' => 'berita.create',
    'store' => 'berita.store',
    'show' => 'berita.show',
    'edit' => 'berita.edit',
    'update' => 'berita.update',
    'destroy' => 'berita.destroy',
])->middleware(['auth', 'verified']);
// Route::get('/dashboard/berita/{berita:slug}', [showBerita::class, 'show'])->name('berita.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
