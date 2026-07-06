<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Kelola Pengiriman (Pesanan Baru)</h1>
      <p class="text-muted small">Daftar pesanan baru yang sudah dikonfirmasi lunas (Paid). Tentukan metode dan alokasikan kurir berdasarkan volume pesanan.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Left Side: Aturan Bisnis & Rekomendasi -->
  <div class="col-lg-3 col-12">
    <div class="card border-0 p-4 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-info-circle text-primary me-2"></i>Aturan Pengiriman</h5>
      <p class="small text-muted mb-3">Sistem secara otomatis menganalisis volume barang belanjaan untuk memberikan rekomendasi pengiriman terbaik:</p>
      
      <div class="mb-3 p-3 rounded-3" style="background: rgba(224, 110, 75, 0.08); border-left: 4px solid #e06e4b;">
        <span class="fw-bold text-dark d-block small" style="color: #e06e4b !important;">Volume Besar (&ge; 50 Unit)</span>
        <span class="small text-muted">Direkomendasikan menggunakan <strong>Kurir Parung (Manual)</strong> menggunakan armada mobil boks sendiri untuk menghemat biaya grosir.</span>
      </div>

      <div class="p-3 rounded-3" style="background: rgba(2, 132, 199, 0.08); border-left: 4px solid #0284c7;">
        <span class="fw-bold text-dark d-block small" style="color: #0284c7 !important;">Volume Kecil (&lt; 50 Unit)</span>
        <span class="small text-muted">Direkomendasikan menggunakan <strong>Jasa Agregator</strong> (JNE, GoSend, GrabExpress) demi kecepatan pengiriman ritel.</span>
      </div>
    </div>
  </div>

  <!-- Right Side: Daftar Pesanan Siap Kirim -->
  <div class="col-lg-9 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-package text-primary me-2"></i>Antrean Pesanan Lunas</h5>
      <p class="text-muted small mb-4">Silakan alokasikan logistik untuk pesanan pelanggan berikut ini.</p>
      
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
              <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Order ID</th>
              <th style="font-weight: 600; color: #64748b;">Rincian Barang & Volume</th>
              <th style="font-weight: 600; color: #64748b;">Tujuan</th>
              <th style="font-weight: 600; color: #64748b;">Rekomendasi Metode</th>
              <th style="font-weight: 600; color: #64748b;">Alokasi Logistik</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($deliveries)): ?>
              <?php foreach ($deliveries as $del): ?>
                <?php 
                  $totalQty = 0;
                  if (!empty($del['details'])) {
                      foreach ($del['details'] as $item) {
                          $totalQty += $item['qty'];
                      }
                  }
                  $isManual = $del['metode_pengiriman'] === 'manual';
                ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td class="ps-3"><strong>#<?= esc($del['transaksi_id']) ?></strong><br><span class="badge bg-success py-1 px-2" style="font-size: 0.65rem !important;">Paid</span></td>
                  <td>
                    <div class="mb-2">
                      <?php if (!empty($del['details'])): ?>
                        <?php foreach ($del['details'] as $item): ?>
                          <div class="small mb-1">
                            <i class="ti ti-point me-1 text-primary"></i><strong><?= esc($item['produk_nama']) ?></strong> (<?= esc($item['qty']) ?> <?= esc($item['satuan']) ?>)
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-muted small">Tidak ada detail barang</span>
                      <?php endif; ?>
                    </div>
                    <span class="text-muted small" style="font-size: 0.8rem;">Status: <strong><?= esc($del['status_pengiriman']) ?></strong></span>
                  </td>
                  <td><?= esc($del['shipping_address']) ?></td>
                  <td>
                    <?php if ($totalQty >= 50): ?>
                      <span class="badge" style="background-color: rgba(224, 110, 75, 0.1); color: #e06e4b !important; font-weight: 600; padding: 6px 10px;">
                        <i class="ti ti-truck me-1"></i>Manual (&ge; 50 Unit)
                      </span>
                    <?php else: ?>
                      <span class="badge" style="background-color: rgba(2, 132, 199, 0.1); color: #0284c7 !important; font-weight: 600; padding: 6px 10px;">
                        <i class="ti ti-package me-1"></i>Agregator (&lt; 50 Unit)
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <form action="<?= base_url('distribusi/pengiriman/update/' . $del['id']) ?>" method="post" class="d-flex flex-column gap-2 py-2 form-logistik-alokasi" style="width: 200px;">
                      <!-- Metode Select -->
                      <select name="metode_select" class="form-select form-control select-metode-kirim" style="height: 38px; border-radius: 6px; font-size: 0.85rem;" required>
                        <option value="manual" <?= $isManual ? 'selected' : '' ?>>Manual (Kurir Parung)</option>
                        <option value="JNE" <?= (!$isManual && $del['ekspedisi_nama'] === 'JNE') ? 'selected' : '' ?>>JNE (Agregator)</option>
                        <option value="J&T" <?= (!$isManual && $del['ekspedisi_nama'] === 'J&T') ? 'selected' : '' ?>>J&T (Agregator)</option>
                        <option value="Shopee Express" <?= (!$isManual && $del['ekspedisi_nama'] === 'Shopee Express') ? 'selected' : '' ?>>Shopee Express</option>
                      </select>

                      <!-- Supir Selector Container -->
                      <div class="supir-select-container">
                        <select name="supir_id" class="form-select form-control" style="height: 38px; border-radius: 6px; font-size: 0.85rem;">
                          <option value="">-- Pilih Supir --</option>
                          <?php foreach ($drivers as $drv): ?>
                            <option value="<?= $drv['id'] ?>" <?= $drv['id'] == $del['supir_id'] ? 'selected' : '' ?>><?= esc($drv['nama']) ?> (<?= esc($drv['nomor_kendaraan']) ?>)</option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <!-- Resi Input Container -->
                      <div class="resi-input-container d-none">
                        <input type="text" name="nomor_resi" placeholder="Input Resi / Order ID" value="<?= esc($del['nomor_resi']) ?>" class="form-control" style="height: 38px; border-radius: 6px; font-size: 0.85rem;">
                      </div>

                      <!-- Status Select -->
                      <select name="status_pengiriman" class="form-select form-control" style="height: 38px; border-radius: 6px; font-size: 0.85rem;" required>
                        <option value="Menunggu Penjadwalan" <?= $del['status_pengiriman'] === 'Menunggu Penjadwalan' ? 'selected' : '' ?>>Menunggu Penjadwalan</option>
                        <option value="Sedang Dikirim" <?= $del['status_pengiriman'] === 'Sedang Dikirim' ? 'selected' : '' ?>>Sedang Dikirim</option>
                        <option value="Selesai" <?= $del['status_pengiriman'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                      </select>
                      
                      <button type="submit" class="btn btn-sm btn-primary w-100" style="border-radius: 6px; font-size: 0.8rem;">Update Status</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada antrean pengiriman aktif.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('.form-logistik-alokasi');
  forms.forEach(form => {
    const selectMetode = form.querySelector('.select-metode-kirim');
    const supirContainer = form.querySelector('.supir-select-container');
    const supirSelect = supirContainer.querySelector('select');
    const resiContainer = form.querySelector('.resi-input-container');
    const resiInput = resiContainer.querySelector('input');

    function toggleFields() {
      const val = selectMetode.value;
      if (val === 'manual') {
        supirContainer.classList.remove('d-none');
        supirSelect.setAttribute('required', 'required');
        resiContainer.classList.add('d-none');
        resiInput.removeAttribute('required');
      } else {
        supirContainer.classList.add('d-none');
        supirSelect.removeAttribute('required');
        resiContainer.classList.remove('d-none');
        resiInput.setAttribute('required', 'required');
      }
    }

    selectMetode.addEventListener('change', toggleFields);
    toggleFields(); // Initial toggle
  });
});
</script>
<?= $this->endSection() ?>
