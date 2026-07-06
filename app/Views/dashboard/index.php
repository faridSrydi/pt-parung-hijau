<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Dashboard Overview</h4>
        <p class="text-muted small mb-0">Informasi ringkas mengenai performa PT Parung Hijau hari ini.</p>
    </div>
    <div>
        <button class="btn btn-emerald text-white bg-success border-0 px-3 py-2" style="background-color: #10b981 !important;">
            <i class="bi bi-plus-lg me-1"></i> Buat Laporan Baru
        </button>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center">
                <div class="card-stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ms-3">
                    <span class="text-muted small d-block">Total Penjualan</span>
                    <h5 class="fw-bold mb-0">Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></h5>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                <span class="text-success fw-bold">Omset Terkumpul</span> (Lunas)
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center">
                <div class="card-stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ms-3">
                    <span class="text-muted small d-block">Pengguna Terdaftar</span>
                    <h5 class="fw-bold mb-0"><?= esc($totalUsers) ?> Akun</h5>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Semua hak akses aktif
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center">
                <div class="card-stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="ms-3">
                    <span class="text-muted small d-block">Stok Produk</span>
                    <h5 class="fw-bold mb-0"><?= esc($totalStock) ?> Unit</h5>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Tersedia di katalog
            </div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center">
                <div class="card-stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-chat-left-dots"></i>
                </div>
                <div class="ms-3">
                    <span class="text-muted small d-block">Total Transaksi</span>
                    <h5 class="fw-bold mb-0"><?= esc($totalTransactions) ?> Order</h5>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Status lunas/pending/batal
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="card border-0 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold text-dark mb-3">Aktivitas Transaksi Terbaru</h5>
        <div class="table-responsive p-0 shadow-none border-0">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID Transaksi</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Total Pembayaran</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
          <tbody>
            <?php if (!empty($recentTransactions)): ?>
              <?php foreach ($recentTransactions as $tx): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td><span class="fw-bold">#<?= esc($tx['id']) ?></span></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="bg-light rounded-circle p-2 me-2 text-center" style="width: 32px; height: 32px; font-size: 0.8rem; line-height: 1;">
                        <?= strtoupper(substr($tx['username'] ?? 'U', 0, 2)) ?>
                      </div>
                      <div>
                        <h6 class="mb-0 small fw-bold"><?= esc($tx['recipient_name']) ?></h6>
                        <span class="text-muted text-xs d-block" style="font-size: 0.75rem;"><?= esc($tx['recipient_phone']) ?></span>
                      </div>
                    </div>
                  </td>
                  <td><?= date('d M Y', strtotime($tx['tanggal_transaksi'])) ?></td>
                  <td class="fw-bold">Rp <?= number_format($tx['total_harga'], 0, ',', '.') ?></td>
                  <td>
                    <?php if ($tx['status_pembayaran'] === 'Lunas'): ?>
                      <span class="badge bg-success bg-opacity-10 text-success badge-clean">Lunas</span>
                    <?php elseif ($tx['status_pembayaran'] === 'Batal'): ?>
                      <span class="badge bg-danger bg-opacity-10 text-danger badge-clean">Batal</span>
                    <?php else: ?>
                      <span class="badge bg-warning bg-opacity-10 text-warning badge-clean"><?= esc($tx['status_pembayaran']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?= base_url('admin/lihat-transaksi') ?>" class="btn btn-light btn-sm text-dark border-0"><i class="bi bi-eye"></i> Detail</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td>
              </tr>
            <?php endif; ?>
          </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
