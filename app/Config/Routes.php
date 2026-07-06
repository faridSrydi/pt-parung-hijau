<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public Routes (Halaman Depan)
$routes->get('/', 'Home::index');
$routes->get('tentang-kami', 'Home::tentangKami');
$routes->get('produk-kami', 'Home::produkKami');
$routes->get('kontak', 'Home::kontak');
$routes->get('checkout', 'Home::checkout');
$routes->post('checkout/proses', 'Home::prosesCheckout');
$routes->post('checkout/cek-stok', 'Home::cekStok');

// Unit Bisnis Detail Routes
$routes->group('unit-bisnis', static function ($routes) {
    $routes->get('(:segment)', 'UnitBisnis::detail/$1');
});

// Protected Actor Dashboard Routes (CI Shield 'group' filter)
$routes->group('admin', ['filter' => 'group:admin'], static function ($routes) {
    $routes->get('dashboard', '\App\Controllers\Admin\Dashboard::index');
    $routes->get('kelola-akun', '\App\Controllers\Admin\Dashboard::kelolaAkun');
    $routes->post('akun/tambah', '\App\Controllers\Admin\Dashboard::tambahAkun');
    $routes->post('akun/edit/(:num)', '\App\Controllers\Admin\Dashboard::editAkun/$1');
    $routes->get('akun/hapus/(:num)', '\App\Controllers\Admin\Dashboard::hapusAkun/$1');

    $routes->get('kelola-unit', '\App\Controllers\Admin\Dashboard::kelolaUnit');
    $routes->post('unit/tambah', '\App\Controllers\Admin\Dashboard::tambahUnit');
    $routes->post('unit/edit/(:segment)', '\App\Controllers\Admin\Dashboard::editUnit/$1');
    $routes->get('unit/hapus/(:segment)', '\App\Controllers\Admin\Dashboard::hapusUnit/$1');

    $routes->get('kelola-produk', '\App\Controllers\Admin\Dashboard::kelolaProduk');
    $routes->post('produk/tambah', '\App\Controllers\Admin\Dashboard::tambahProduk');
    $routes->post('produk/edit/(:segment)', '\App\Controllers\Admin\Dashboard::editProduk/$1');
    $routes->get('produk/hapus/(:segment)', '\App\Controllers\Admin\Dashboard::hapusProduk/$1');

    $routes->get('lihat-transaksi', '\App\Controllers\Admin\Dashboard::lihatTransaksi');
    $routes->get('transaksi/verifikasi/(:segment)', '\App\Controllers\Admin\Dashboard::verifikasiTransaksi/$1');
    $routes->get('transaksi/batal/(:segment)', '\App\Controllers\Admin\Dashboard::batalTransaksi/$1');

    $routes->get('laporan-ekspor', '\App\Controllers\Admin\Dashboard::laporanEkspor');
    $routes->get('laporan/ekspor', '\App\Controllers\Admin\Dashboard::ekspor');

    $routes->get('kelola-supir', '\App\Controllers\Admin\Dashboard::kelolaSupir');
    $routes->post('supir/tambah', '\App\Controllers\Admin\Dashboard::tambahSupir');
    $routes->post('supir/edit/(:num)', '\App\Controllers\Admin\Dashboard::editSupir/$1');
    $routes->get('supir/hapus/(:num)', '\App\Controllers\Admin\Dashboard::hapusSupir/$1');
});

$routes->group('produksi', ['filter' => 'group:produksi'], static function ($routes) {
    $routes->get('dashboard', '\App\Controllers\Produksi\Dashboard::index');
    $routes->get('input', '\App\Controllers\Produksi\Dashboard::input');
    $routes->post('input', '\App\Controllers\Produksi\Dashboard::simpanPanen');
    $routes->get('riwayat', '\App\Controllers\Produksi\Dashboard::riwayat');
    $routes->post('update/(:num)', '\App\Controllers\Produksi\Dashboard::updatePanen/$1');
    $routes->get('hapus/(:num)', '\App\Controllers\Produksi\Dashboard::hapusPanen/$1');
});

$routes->group('distribusi', ['filter' => 'group:distribusi'], static function ($routes) {
    $routes->get('dashboard', '\App\Controllers\Distribusi\Dashboard::index');
    $routes->get('pengiriman', '\App\Controllers\Distribusi\Dashboard::pengiriman');
    $routes->post('pengiriman/update/(:num)', '\App\Controllers\Distribusi\Dashboard::updateLogistik/$1');
    $routes->get('resi', '\App\Controllers\Distribusi\Dashboard::resi');
    $routes->post('resi/update/(:num)', '\App\Controllers\Distribusi\Dashboard::updateResi/$1');
});

$routes->group('pelanggan', ['filter' => 'group:pelanggan'], static function ($routes) {
    $routes->get('dashboard', '\App\Controllers\Pelanggan\Dashboard::index');
    $routes->post('alamat/simpan', '\App\Controllers\Pelanggan\Dashboard::simpanAlamat');
    $routes->post('alamat/update/(:num)', '\App\Controllers\Pelanggan\Dashboard::updateAlamat/$1');
    $routes->post('alamat/hapus/(:num)', '\App\Controllers\Pelanggan\Dashboard::hapusAlamat/$1');
    $routes->post('transaksi/bukti/(:segment)', '\App\Controllers\Pelanggan\Dashboard::kirimBukti/$1');
});

// Legacy / General Dashboard Route (For fallback)
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'session']);

// Load Shield auth routes
service('auth')->routes($routes);
