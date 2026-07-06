<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Update Status Resi & Pengiriman</h1>
      <p class="text-muted small">Kelola status perjalanan kurir secara berkala untuk memantau pengiriman barang belanjaan pelanggan di lapangan.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-refresh text-primary me-2"></i>Status Perjalanan Pengiriman</h5>
        <button class="btn btn-sm btn-light border px-2 py-1" onclick="location.reload();"><i class="ti ti-refresh"></i> Refresh</button>
      </div>
 
      <!-- Filter Bar -->
      <div class="row g-3 align-items-center mb-4">
        <div class="col-md-4 col-12">
          <div class="input-group input-group-sm border rounded-2 bg-white">
            <span class="input-group-text bg-transparent border-0 text-muted"><i class="ti ti-search"></i></span>
            <input type="text" id="search-resi" class="form-control border-0 bg-transparent px-0" placeholder="Cari order ID atau alamat...">
          </div>
        </div>
        <div class="col-md-3 col-12">
          <select id="filter-status" class="form-select form-select-sm border rounded-2" style="height: 38px;">
            <option value="">Semua Status</option>
            <option value="Menunggu Penjadwalan">Menunggu Penjadwalan</option>
            <option value="Diproses">Diproses</option>
            <option value="Sedang Dikirim">Sedang Dikirim</option>
            <option value="Selesai">Selesai</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
              <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Order ID</th>
              <th style="font-weight: 600; color: #64748b;">Rincian Barang</th>
              <th style="font-weight: 600; color: #64748b;">Kurir / No Resi / Plat</th>
              <th style="font-weight: 600; color: #64748b;">Metode</th>
              <th style="font-weight: 600; color: #64748b;">Tujuan</th>
              <th style="font-weight: 600; color: #64748b;">Status Terkini</th>
              <th class="text-end pe-3" style="font-weight: 600; color: #64748b;">Aksi Pembaruan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($deliveries)): ?>
              <?php foreach ($deliveries as $del): ?>
                <?php 
                  $isManual = $del['metode_pengiriman'] === 'manual';
                  $courierName = $isManual ? 'Kurir Parung' : esc($del['ekspedisi_nama'] ?? 'Ekspedisi');
                  $courierDetail = $isManual 
                      ? 'Armada: ' . esc($del['nomor_kendaraan']) . ' (' . esc($del['supir_nama']) . ')'
                      : 'Resi: ' . esc($del['nomor_resi'] ?: 'Belum di-input');
                ?>
                <tr class="resi-row" 
                    data-id="<?= esc(strtolower($del['transaksi_id'])) ?>" 
                    data-address="<?= esc(strtolower($del['shipping_address'])) ?>" 
                    data-status="<?= esc($del['status_pengiriman']) ?>"
                    style="border-bottom: 1px solid #f8fafc;">
                  <td class="ps-3"><strong>#<?= esc($del['transaksi_id']) ?></strong></td>
                  <td>
                    <?php if (!empty($del['details'])): ?>
                      <?php foreach ($del['details'] as $item): ?>
                        <div class="small mb-1">
                          <strong><?= esc($item['produk_nama']) ?></strong> (<?= esc($item['qty']) ?> <?= esc($item['satuan']) ?>)
                        </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted small">Tidak ada detail barang</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="fw-bold text-dark"><?= esc($courierName) ?></span><br>
                    <span class="text-muted small"><?= esc($courierDetail) ?></span>
                  </td>
                  <td>
                    <?php if ($isManual): ?>
                      <span class="badge" style="background-color: rgba(224, 110, 75, 0.1); color: #e06e4b !important; font-weight: 600; padding: 6px 10px;">Manual</span>
                    <?php else: ?>
                      <span class="badge" style="background-color: rgba(2, 132, 199, 0.1); color: #0284c7 !important; font-weight: 600; padding: 6px 10px;">Agregator</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($del['shipping_address']) ?></td>
                  <td>
                    <?php 
                      $status = $del['status_pengiriman'];
                      $badgeStyle = 'background-color: rgba(182, 138, 88, 0.1); color: #b68a58 !important;'; // default gold/yellow
                      if ($status === 'Selesai') {
                          $badgeStyle = 'background-color: rgba(12, 138, 95, 0.1); color: #0c8a5f !important;'; // green
                      } elseif ($status === 'Sedang Dikirim') {
                          $badgeStyle = 'background-color: rgba(2, 132, 199, 0.1); color: #0284c7 !important;'; // blue
                      }
                    ?>
                    <span class="badge badge-status" style="<?= $badgeStyle ?> font-weight: 600; padding: 6px 10px;">
                      <?= esc($status) ?>
                    </span>
                  </td>
                  <td class="text-end pe-3 action-cell">
                    <?php if ($del['status_pengiriman'] === 'Selesai'): ?>
                      <span class="text-success small"><i class="ti ti-circle-check"></i> Selesai</span>
                    <?php else: ?>
                      <form action="<?= base_url('distribusi/resi/update/' . $del['id']) ?>" method="post" class="d-flex align-items-center justify-content-end gap-2">
                        <?php if (!$isManual): ?>
                          <input type="text" name="nomor_resi" placeholder="Input Resi" value="<?= esc($del['nomor_resi']) ?>" class="form-control form-control-sm" style="width: 120px; height: 32px; font-size: 0.8rem; border-radius: 4px;" required>
                        <?php endif; ?>
                        <select name="status_pengiriman" class="form-select form-select-sm" style="width: 130px; height: 32px; font-size: 0.8rem; border-radius: 4px;" required>
                          <?php if ($isManual): ?>
                            <option value="Menunggu Penjadwalan" <?= $del['status_pengiriman'] === 'Menunggu Penjadwalan' ? 'selected' : '' ?>>Menunggu Jadwal</option>
                          <?php else: ?>
                            <option value="Diproses" <?= $del['status_pengiriman'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                          <?php endif; ?>
                          <option value="Sedang Dikirim" <?= $del['status_pengiriman'] === 'Sedang Dikirim' ? 'selected' : '' ?>>Sedang Dikirim</option>
                          <option value="Selesai" <?= $del['status_pengiriman'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary" style="height: 32px; font-size: 0.8rem; border-radius: 4px;">Update</button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada pengiriman terdaftar.</td>
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
  const searchInput = document.getElementById('search-resi');
  const filterStatus = document.getElementById('filter-status');
  const resiRows = document.querySelectorAll('.resi-row');

  function filterTable() {
    const query = searchInput.value.toLowerCase().trim();
    const selectedStatus = filterStatus.value;

    resiRows.forEach(row => {
      const id = row.getAttribute('data-id');
      const address = row.getAttribute('data-address');
      const status = row.getAttribute('data-status');

      const matchesSearch = id.includes(query) || address.includes(query);
      const matchesStatus = !selectedStatus || status === selectedStatus;

      if (matchesSearch && matchesStatus) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  if (searchInput && filterStatus) {
    searchInput.addEventListener('input', filterTable);
    filterStatus.addEventListener('change', filterTable);
  }
});
</script>
<?= $this->endSection() ?>
