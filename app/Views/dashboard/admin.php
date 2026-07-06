<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Dashboard Overview</h1>
      <p class="text-muted small">Selamat datang kembali di panel administrasi terpadu Smart Farming System.</p>
    </div>
  </div>
</div>

<!-- Stats cards in Dash template style with Tabler icons -->
<div class="row g-3 mb-4">
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card p-4 card-stat card-terracotta-soft rounded-2" onclick="window.location.href='<?= base_url('admin/kelola-akun') ?>'">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-users fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Kelola Akun</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= $totalUsers ?> Akun</h3>
          <p class="subtext mb-0 small">Pengguna Terdaftar</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card p-4 card-stat card-green-soft rounded-2" onclick="window.location.href='<?= base_url('admin/kelola-unit') ?>'">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-building fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Unit Bisnis</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= $totalUnits ?> Kelompok</h3>
          <p class="subtext mb-0 small">Kelompok Tani Aktif</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card p-4 card-stat card-blue-soft rounded-2" onclick="window.location.href='<?= base_url('admin/kelola-produk') ?>'">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-box-seam fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Katalog Produk</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= $totalProducts ?> Produk</h3>
          <p class="subtext mb-0 small">Aktif di Platform</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card p-4 card-stat card-gold-soft rounded-2" onclick="window.location.href='<?= base_url('admin/lihat-transaksi') ?>'">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-receipt fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Transaksi Lunas</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;">
            <?php 
              if ($totalOmset >= 1000000000) {
                  echo 'Rp ' . number_format($totalOmset / 1000000000, 1) . ' M';
              } elseif ($totalOmset >= 1000000) {
                  echo 'Rp ' . number_format($totalOmset / 1000000, 1) . ' Jt';
              } else {
                  echo 'Rp ' . number_format($totalOmset, 0, ',', '.');
              }
            ?>
          </h3>
          <p class="subtext mb-0 small">Omset Selesai</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <!-- Left Side: Kelola Unit Bisnis & Kelola Produk -->
  <div class="col-lg-8 col-12">
    <!-- Kelola Unit Bisnis -->
    <div class="card border-0 mb-4 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-building me-2 text-primary"></i>Kelola Unit Bisnis</h5>
        <a href="<?= base_url('admin/kelola-unit') ?>" class="btn btn-sm btn-outline-success"><i class="ti ti-arrow-right me-1"></i> Kelola</a>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9;">
              <th style="font-weight: 600; color: #64748b;">Nama Unit</th>
              <th style="font-weight: 600; color: #64748b;">Kawasan Operasional</th>
              <th style="font-weight: 600; color: #64748b;">Fokus Produksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($units)): ?>
              <?php foreach ($units as $unit): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td><strong><?= esc($unit['nama']) ?></strong></td>
                  <td><?= esc($unit['wilayah']) ?></td>
                  <td><span class="badge" style="background-color: #22c55e; color: #fff;"><?= esc($unit['komoditas']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-3">Belum ada unit bisnis.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Kelola Produk -->
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-box-seam me-2 text-primary"></i>Kelola Produk</h5>
        <a href="<?= base_url('admin/kelola-produk') ?>" class="btn btn-sm btn-outline-success"><i class="ti ti-arrow-right me-1"></i> Kelola</a>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9;">
              <th style="font-weight: 600; color: #64748b;">Nama Produk</th>
              <th style="font-weight: 600; color: #64748b;">Unit Bisnis</th>
              <th style="font-weight: 600; color: #64748b;">Harga Satuan</th>
              <th style="font-weight: 600; color: #64748b;">Stok</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($products)): ?>
              <?php foreach ($products as $prod): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td><?= esc($prod['nama']) ?></td>
                  <td><span class="badge" style="background-color: #e07c5a; color: #fff;"><?= esc(ucfirst($prod['unit_bisnis_id'])) ?></span></td>
                  <td>Rp <?= number_format($prod['harga'], 0, ',', '.') ?></td>
                  <td><?= esc($prod['stok']) ?> <?= esc($prod['satuan']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-3">Belum ada produk.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Right Side: Kelola Akun & Transaksi PG -->
  <div class="col-lg-4 col-12">
    <!-- Kelola Akun -->
    <div class="card border-0 mb-4 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-users me-2 text-primary"></i>Kelola Akun</h5>
        <a href="<?= base_url('admin/kelola-akun') ?>" class="btn btn-sm btn-outline-success"><i class="ti ti-arrow-right"></i></a>
      </div>
      <ul class="list-group list-group-flush">
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $u): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3" style="border-bottom: 1px solid #f8fafc;">
              <div>
                <h6 class="mb-0 fw-bold" style="font-size: 0.9rem; color: #1e293b;"><?= esc($u['username']) ?></h6>
                <span class="small text-muted" style="font-size: 0.8rem;"><?= esc($u['email']) ?></span>
              </div>
              <?php 
                $roleClass = 'bg-primary';
                if ($u['role'] === 'admin') { $roleClass = 'bg-danger'; }
                elseif ($u['role'] === 'produksi') { $roleClass = 'bg-success'; }
                elseif ($u['role'] === 'distribusi') { $roleClass = 'bg-info'; }
              ?>
              <span class="badge rounded-pill <?= $roleClass ?>" style="font-size: 0.75rem;"><?= esc(ucfirst($u['role'])) ?></span>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="list-group-item text-center text-muted py-3">Belum ada akun.</li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Transaksi & Payment Gateway -->
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-credit-card me-2 text-primary"></i>Transaksi Terakhir</h5>
        <a href="<?= base_url('admin/lihat-transaksi') ?>" class="btn btn-sm btn-outline-success"><i class="ti ti-arrow-right"></i></a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th style="font-size: 0.8rem; color: #64748b;">Order</th>
              <th style="font-size: 0.8rem; color: #64748b;">Total</th>
              <th style="font-size: 0.8rem; color: #64748b;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($transactions)): ?>
              <?php foreach ($transactions as $tx): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td>#<?= esc($tx['id']) ?></td>
                  <td class="fw-bold text-dark">Rp <?= number_format($tx['total_harga'], 0, ',', '.') ?></td>
                  <td>
                    <?php if ($tx['status_pembayaran'] === 'Lunas'): ?>
                      <span class="badge bg-success bg-opacity-10 text-success rounded-pill" style="font-size: 0.75rem;">Lunas</span>
                    <?php else: ?>
                      <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill" style="font-size: 0.75rem;"><?= esc($tx['status_pembayaran']) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-3">Belum ada transaksi.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
