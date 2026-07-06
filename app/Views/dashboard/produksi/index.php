<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Dashboard Produksi</h1>
      <p class="text-muted small">Selamat datang kembali! Berikut ringkasan aktivitas produksi dan panen dari kelompok tani Smart Farming.</p>
    </div>
  </div>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
  <!-- Total Volume Panen -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-green-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-box-seam fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Total Panen Bulan Ini</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($totalHarvest) ?> Unit</h3>
          <p class="subtext mb-0 small">Berdasarkan log produksi terbaru</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Kelompok Tani Aktif -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-blue-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-building fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Kelompok Tani Aktif</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($activeUnits) ?> Unit Bisnis</h3>
          <p class="subtext mb-0 small">Semua unit beroperasi normal</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Kualitas Hasil Panen -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-gold-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-star fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Kualitas Unggul (Grade A)</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($gradeAPercentage) ?>% Persentase</h3>
          <p class="subtext mb-0 small">Optimalisasi pasokan pasar premium</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Left Side: Quick Navigation / Shortcuts -->
  <div class="col-lg-5 col-12">
    <div class="card border-0 p-4 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-directions text-primary me-2"></i>Aksi Cepat</h5>
      <p class="text-muted small mb-4">Navigasi langsung ke menu pengelolaan data produksi di bawah ini.</p>
      
      <div class="d-flex flex-column gap-3">
        <a href="<?= base_url('produksi/input') ?>" class="d-flex align-items-center p-3 text-decoration-none rounded-3 border hover-shadow" style="background: #f8fafc; transition: all 0.2s;">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
            <i class="ti ti-plus fs-3"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Input Hasil Produksi</h6>
            <p class="text-muted mb-0 small">Catat panen baru kelompok tani ke database.</p>
          </div>
        </a>
        
        <a href="<?= base_url('produksi/riwayat') ?>" class="d-flex align-items-center p-3 text-decoration-none rounded-3 border hover-shadow" style="background: #f8fafc; transition: all 0.2s;">
          <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
            <i class="ti ti-receipt fs-3"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Update & Riwayat</h6>
            <p class="text-muted mb-0 small">Lihat, edit, dan saring riwayat pencatatan panen.</p>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Right Side: Recent Activity -->
  <div class="col-lg-7 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-clock text-primary me-2"></i>Aktivitas Panen Terakhir</h5>
        <a href="<?= base_url('produksi/riwayat') ?>" class="btn btn-sm btn-light border px-2 py-1 small">Lihat Semua</a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9;">
              <th style="font-weight: 600; color: #64748b;">Tanggal</th>
              <th style="font-weight: 600; color: #64748b;">Produk</th>
              <th style="font-weight: 600; color: #64748b;">Unit</th>
              <th style="font-weight: 600; color: #64748b;">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($recentLogs)): ?>
              <?php foreach ($recentLogs as $log): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td><?= date('d M Y', strtotime($log['tanggal_panen'])) ?></td>
                  <td><strong><?= esc($log['produk_nama']) ?></strong></td>
                  <td><?= esc(ucfirst($log['unit_bisnis_id'])) ?></td>
                  <td><?= esc($log['volume']) ?> <?= esc($log['satuan']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Belum ada riwayat hasil panen.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
