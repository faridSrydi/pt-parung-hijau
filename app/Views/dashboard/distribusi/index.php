<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Dashboard Distribusi</h1>
      <p class="text-muted small">Selamat datang kembali! Pantau alokasi kurir, status resi, dan pastikan pengiriman sampai ke tangan pelanggan dengan selamat.</p>
    </div>
  </div>
</div>

<!-- Shipping Status Stats -->
<div class="row g-3 mb-4">
  <!-- Siap Dikirim (Paid) -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-gold-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-box-seam fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Siap Dikirim (Paid)</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($siapKirim) ?> Pesanan</h3>
          <p class="subtext mb-0 small">Menunggu Alokasi Kurir</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Sedang Dikirim -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-green-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-truck fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Sedang Dikirim</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($sedangKirim) ?> Paket</h3>
          <p class="subtext mb-0 small">Dalam Perjalanan Kurir</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Telah Diterima -->
  <div class="col-md-4 col-12">
    <div class="card p-4 card-stat card-blue-soft rounded-2">
      <div class="d-flex gap-3">
        <div class="icon-shape icon-md rounded-2">
          <i class="ti ti-check fs-4"></i>
        </div>
        <div>
          <h2 class="mb-3 fs-6" style="font-size: 0.9rem; font-weight: 600;">Telah Diterima</h2>
          <h3 class="fw-bold mb-0" style="font-size: 1.5rem; font-weight: 700;"><?= esc($telahDiterima) ?> Paket</h3>
          <p class="subtext mb-0 small">Sukses Terantar ke Pelanggan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Left Side: Quick Navigation / Shortcuts -->
  <div class="col-lg-5 col-12">
    <div class="card border-0 p-4 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-directions text-primary me-2"></i>Aksi Logistik</h5>
      <p class="text-muted small mb-4">Navigasi langsung untuk mengelola pengiriman pesanan dan memantau status resi.</p>
      
      <div class="d-flex flex-column gap-3">
        <a href="<?= base_url('distribusi/pengiriman') ?>" class="d-flex align-items-center p-3 text-decoration-none rounded-3 border hover-shadow" style="background: #f8fafc; transition: all 0.2s;">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
            <i class="ti ti-truck fs-3"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Kelola Pengiriman</h6>
            <p class="text-muted mb-0 small">Proses alokasi kurir internal/eksternal untuk pesanan baru.</p>
          </div>
        </a>
        
        <a href="<?= base_url('distribusi/resi') ?>" class="d-flex align-items-center p-3 text-decoration-none rounded-3 border hover-shadow" style="background: #f8fafc; transition: all 0.2s;">
          <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
            <i class="ti ti-refresh fs-3"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Update Status Resi</h6>
            <p class="text-muted mb-0 small">Pantau status perjalanan kurir dan selesaikan kiriman.</p>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Right Side: Recent Activity -->
  <div class="col-lg-7 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-clock text-primary me-2"></i>Pengiriman Terbaru</h5>
        <a href="<?= base_url('distribusi/resi') ?>" class="btn btn-sm btn-light border px-2 py-1 small">Lihat Semua</a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9;">
              <th style="font-weight: 600; color: #64748b;">Order</th>
              <th style="font-weight: 600; color: #64748b;">Tujuan</th>
              <th style="font-weight: 600; color: #64748b;">Kurir</th>
              <th style="font-weight: 600; color: #64748b;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($recentDeliveries)): ?>
              <?php foreach ($recentDeliveries as $deliv): ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td><strong>#<?= esc($deliv['transaksi_id']) ?></strong></td>
                  <td><?= esc($deliv['shipping_address']) ?></td>
                  <td><?= esc($deliv['supir_nama'] ?: 'Belum Ditugaskan') ?></td>
                  <td>
                    <?php if ($deliv['status_pengiriman'] === 'Selesai'): ?>
                      <span class="badge" style="background-color: rgba(12, 138, 95, 0.1); color: #0c8a5f !important; padding: 4px 8px; font-weight: 600;">Selesai</span>
                    <?php elseif ($deliv['status_pengiriman'] === 'Dikirim'): ?>
                      <span class="badge" style="background-color: rgba(2, 132, 199, 0.1); color: #0284c7 !important; padding: 4px 8px; font-weight: 600;">Dikirim</span>
                    <?php else: ?>
                      <span class="badge" style="background-color: rgba(182, 138, 88, 0.1); color: #b68a58 !important; padding: 4px 8px; font-weight: 600;"><?= esc($deliv['status_pengiriman']) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Belum ada pengiriman terdaftar.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
