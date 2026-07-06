<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title><?= $title ?? 'Dashboard' ?> | PT Parung Hijau Perkasa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" />
  
  <!-- Compiled Assets from Dash -->
  <script type="module" crossorigin src="<?= base_url('dash/assets/js/main.js') ?>"></script>
  <link rel="stylesheet" crossorigin href="<?= base_url('dash/assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin-styles.css?v=2') ?>">
</head>

<body>
  <div id="overlay" class="overlay"></div>
  
  <!-- TOPBAR -->
  <nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
    <button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm ">
      <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>

    <!-- MOBILE -->
    <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
      <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>
    
    <div>
      <!-- Navbar nav -->
      <ul class="list-unstyled d-flex align-items-center mb-0 gap-1">
        <!-- Profile Dropdown -->
        <li class="ms-3 dropdown">
          <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="d-flex align-items-center text-decoration-none">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 34px; height: 34px; font-weight: 600; font-size: 0.85rem;">
              <?= strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) ?>
            </div>
            <span class="small font-weight-bold d-none d-sm-inline-block text-dark" style="margin-left: 6px;"><?= auth()->user()->username ?? 'User' ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 200px;">
            <div>
              <div class="d-flex gap-3 align-items-center border-dashed border-bottom px-3 py-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; font-size: 1rem;">
                  <?= strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) ?>
                </div>
                <div>
                  <h4 class="mb-0 small font-weight-bold"><?= auth()->user()->username ?? 'User' ?></h4>
                  <p class="mb-0 small text-muted"><?= auth()->user()->email ?? 'user@test.com' ?></p>
                </div>
              </div>
              <div class="p-3 d-flex flex-column gap-1 small lh-lg">
                <a href="<?= base_url() ?>" class="text-decoration-none text-dark">
                  <span>Halaman Utama</span>
                </a>
                <a href="<?= base_url('logout') ?>" class="text-decoration-none text-danger">
                  <span>Keluar</span>
                </a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- SIDEBAR -->
  <?php
    $user = auth()->user();
    $currentPath = uri_string(); // e.g. "admin/dashboard", "admin/kelola-akun"
  ?>
  <aside id="sidebar" class="sidebar">
    <div class="logo-area" style="border-bottom: 1px solid #f1f5f9; padding: 1.5rem 1rem;">
      <a href="<?= base_url() ?>" class="d-inline-flex align-items-center text-decoration-none">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" width="32">
        <span class="logo-text ms-2 font-weight-bold text-dark" style="font-size: 1.1rem; letter-spacing: -0.5px; font-weight: 700;">Parung Hijau</span>
      </a>
    </div>
    <ul class="nav flex-column">
      <li class="px-4 py-2"><small class="nav-text text-muted text-uppercase small" style="font-size: 0.7rem; font-weight: 700;">Main Menu</small></li>
      
      <?php if ($user && $user->inGroup('admin')): ?>
        <li>
          <a class="nav-link <?= ($currentPath === 'admin/dashboard' || $currentPath === 'admin') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
            <i class="ti ti-home"></i><span class="nav-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/kelola-akun' ? 'active' : '' ?>" href="<?= base_url('admin/kelola-akun') ?>">
            <i class="ti ti-users"></i><span class="nav-text">Kelola Akun</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/kelola-unit' ? 'active' : '' ?>" href="<?= base_url('admin/kelola-unit') ?>">
            <i class="ti ti-building"></i><span class="nav-text">Kelola Unit Bisnis</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/kelola-produk' ? 'active' : '' ?>" href="<?= base_url('admin/kelola-produk') ?>">
            <i class="ti ti-box-seam"></i><span class="nav-text">Kelola Produk</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/lihat-transaksi' ? 'active' : '' ?>" href="<?= base_url('admin/lihat-transaksi') ?>">
            <i class="ti ti-report-analytics"></i><span class="nav-text">Lihat Transaksi</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/laporan-ekspor' ? 'active' : '' ?>" href="<?= base_url('admin/laporan-ekspor') ?>">
            <i class="ti ti-receipt"></i><span class="nav-text">Laporan & Ekspor</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'admin/kelola-supir' ? 'active' : '' ?>" href="<?= base_url('admin/kelola-supir') ?>">
            <i class="ti ti-truck"></i><span class="nav-text">Kelola Supir & Armada</span>
          </a>
        </li>
      <?php elseif ($user && $user->inGroup('produksi')): ?>
        <li>
          <a class="nav-link <?= ($currentPath === 'produksi/dashboard' || $currentPath === 'produksi') ? 'active' : '' ?>" href="<?= base_url('produksi/dashboard') ?>">
            <i class="ti ti-home"></i><span class="nav-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'produksi/input' ? 'active' : '' ?>" href="<?= base_url('produksi/input') ?>">
            <i class="ti ti-plus"></i><span class="nav-text">Input Hasil Produksi</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'produksi/riwayat' ? 'active' : '' ?>" href="<?= base_url('produksi/riwayat') ?>">
            <i class="ti ti-receipt"></i><span class="nav-text">Update & Riwayat</span>
          </a>
        </li>
      <?php elseif ($user && $user->inGroup('distribusi')): ?>
        <li>
          <a class="nav-link <?= ($currentPath === 'distribusi/dashboard' || $currentPath === 'distribusi') ? 'active' : '' ?>" href="<?= base_url('distribusi/dashboard') ?>">
            <i class="ti ti-home"></i><span class="nav-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'distribusi/pengiriman' ? 'active' : '' ?>" href="<?= base_url('distribusi/pengiriman') ?>">
            <i class="ti ti-truck"></i><span class="nav-text">Kelola Pengiriman</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?= $currentPath === 'distribusi/resi' ? 'active' : '' ?>" href="<?= base_url('distribusi/resi') ?>">
            <i class="ti ti-refresh"></i><span class="nav-text">Update Status Resi</span>
          </a>
        </li>
      <?php elseif ($user && $user->inGroup('pelanggan')): ?>
        <li>
          <a class="nav-link <?= ($currentPath === 'pelanggan/dashboard' || $currentPath === 'pelanggan') ? 'active' : '' ?>" href="<?= base_url('pelanggan/dashboard') ?>">
            <i class="ti ti-home"></i><span class="nav-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="nav-link" href="<?= base_url('produk-kami') ?>">
            <i class="ti ti-box-seam"></i><span class="nav-text">Belanja Produk</span>
          </a>
        </li>
      <?php endif; ?>

      <li class="px-4 pt-4 pb-2"><small class="nav-text text-muted text-uppercase small" style="font-size: 0.7rem; font-weight: 700;">Account</small></li>
      <li>
        <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
          <i class="ti ti-logout text-danger"></i><span class="nav-text text-danger">Keluar</span>
        </a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main id="content" class="content py-10">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success" role="alert" style="border-radius: 8px;">
          <i class="ti ti-check-circle me-2"></i><strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-10 text-danger" role="alert" style="border-radius: 8px;">
          <i class="ti ti-alert-triangle me-2"></i><strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?= $this->renderSection('content') ?>
    </div>
  <script src="<?= base_url('assets/js/admin-app.js') ?>"></script>
  </main>

  <!-- Global Delete Confirmation Modal -->
  <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <div class="modal-body p-4 text-center">
          <div class="mb-3">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 text-danger" style="width: 64px; height: 64px;">
              <i class="ti ti-alert-triangle" style="font-size: 32px;"></i>
            </div>
          </div>
          <h5 class="fw-bold text-dark mb-2">Konfirmasi Hapus</h5>
          <p class="text-muted small mb-4" id="deleteModalMessage">Apakah Anda yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.</p>
          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-light border w-50" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
            <a href="#" id="btnConfirmDeleteAction" class="btn btn-danger w-50" style="border-radius: 6px;">Ya, Hapus</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
