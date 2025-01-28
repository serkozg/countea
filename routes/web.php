<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\TransaksiController;
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

// Route::get('/', function () {
//     return view('main');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [DashboardController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('barang', BarangController::class);
Route::post('/edit-data-barang', [BarangController::class, 'edit_barang'])->name('get.edit-data-barang');
Route::post('/update-data-barang', [BarangController::class, 'update_barang'])->name('get.update-data-barang');


Route::get('/master-transaksi', [TransaksiController::class, 'master_index']);
Route::post('/master-transaksi', [TransaksiController::class, 'master_index_store'])->name('master-index-store');
Route::post('/edit-master-transaksi', [TransaksiController::class, 'master_index_edit'])->name('master-index-edit');
Route::post('/update-master-transaksi', [TransaksiController::class, 'master_index_update'])->name('master-index-update');
Route::get('/delete-master-transaksi/{id}', [TransaksiController::class, 'master_index_delete'])->name('master-index-delete');


Route::get('/transaksi-pemasukan-index', [TransaksiController::class, 'transaksi_pemasukan_index']);
Route::get('/transaksi-pemasukan', [TransaksiController::class, 'pemasukan_index']);
Route::post('/transaksi-pemasukan', [TransaksiController::class, 'pemasukan_store'])->name('pemasukan.store');
Route::get('/delete-transaksi-pemasukan/{id}', [TransaksiController::class, 'pemasukan_delete'])->name('pemasukan.delete');

Route::get('/transaksi-pengeluaran-index', [TransaksiController::class, 'transaksi_pengeluaran_index']);
Route::get('/transaksi-pengeluaran', [TransaksiController::class, 'pengeluaran_index']);
Route::post('/transaksi-pengeluaran', [TransaksiController::class, 'pengeluaran_store'])->name('pengeluaran.store');
Route::get('/delete-transaksi-pengeluaran/{id}', [TransaksiController::class, 'pengeluaran_delete'])->name('pengeluaran.delete');

Route::get('/transaksi-pengeluaran-barang', [TransaksiController::class, 'pengeluaran_barang_index']);
Route::post('/transaksi-pengeluaran-barang', [TransaksiController::class, 'pengeluaran_barang_store'])->name('pengeluaran-barang.store');
Route::get('/delete-transaksi-pengeluaran-barang/{id}', [TransaksiController::class, 'pengeluaran_barang_delete'])->name('pengeluaran-barang.delete');


Route::get('/laporan-pemasukan-index', [LaporanController::class, 'laporan_pemasukan_index'])->name('laporan.pemasukan');
Route::get('/laporan-pengeluaran-index', [LaporanController::class, 'laporan_pengeluaran_index'])->name('laporan.pengeluaran');
Route::get('/laporan-pengeluaran-barang-index', [LaporanController::class, 'laporan_pengeluaran_barang_index'])->name('laporan.pengeluaran-barang');

Route::get('/keuangan', [KeuanganController::class, 'index']);
Route::post('/keuangan', [KeuanganController::class, 'keuangan_store'])->name('keuangan.store');
Route::post('/edit-keuangan', [KeuanganController::class, 'edit_keuangan'])->name('get.edit-keuangan');
Route::post('/update-keuangan', [KeuanganController::class, 'update_keuangan'])->name('get.update-keuangan');
Route::post('/update-keuangan-image', [KeuanganController::class, 'update_keuangan_image'])->name('get.update-keuangan-image');

require __DIR__.'/auth.php';
