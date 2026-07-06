<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Lihat Transaksi</h1>
      <p class="text-muted small">Pantau log pembayaran dan status pesanan pelanggan PT Parung Hijau Perkasa.</p>
    </div>
  </div>
</div>

<div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h5 class="fw-bold text-dark mb-0"><i class="ti ti-report-analytics me-2 text-primary"></i>Riwayat Transaksi Masuk</h5>
    <button class="btn btn-sm btn-light border px-3 py-2" onclick="location.reload();"><i class="ti ti-refresh me-1"></i> Refresh</button>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr style="border-bottom: 2px solid #f1f5f9;">
          <th style="font-weight: 600; color: #64748b;">Order ID</th>
          <th style="font-weight: 600; color: #64748b;">Tanggal</th>
          <th style="font-weight: 600; color: #64748b;">Pelanggan</th>
          <th style="font-weight: 600; color: #64748b;">Total Pembayaran</th>
          <th style="font-weight: 600; color: #64748b;">Status Bayar</th>
          <th style="font-weight: 600; color: #64748b;">Logistik</th>
          <th class="text-end" style="font-weight: 600; color: #64748b;">Detail</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($transactions)): ?>
          <?php foreach ($transactions as $tx): ?>
            <tr style="border-bottom: 1px solid #f8fafc;">
              <td><strong>#<?= esc($tx['id']) ?></strong></td>
              <td><?= date('d M Y H:i', strtotime($tx['tanggal_transaksi'])) ?></td>
              <td><?= esc($tx['pelanggan_nama'] ?? 'Pelanggan') ?></td>
              <td>Rp <?= number_format($tx['total_harga'], 0, ',', '.') ?></td>
              <td>
                <?php if ($tx['status_pembayaran'] === 'Lunas'): ?>
                  <span class="badge bg-success rounded-pill px-3 py-1">Success</span>
                <?php elseif ($tx['status_pembayaran'] === 'Menunggu Verifikasi'): ?>
                  <span class="badge bg-warning rounded-pill px-3 py-1">Pending Verification</span>
                <?php else: ?>
                  <span class="badge bg-danger rounded-pill px-3 py-1"><?= esc($tx['status_pembayaran']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge bg-info rounded-pill px-3 py-1"><?= esc($tx['logistik_status'] ?? 'Belum Kirim') ?></span>
              </td>
              <td class="text-end">
                <button class="btn btn-sm btn-light py-1 px-2 text-secondary btn-detail-tx" 
                  data-id="<?= esc($tx['id']) ?>" 
                  data-penerima="<?= esc($tx['recipient_name']) ?>" 
                  data-telepon="<?= esc($tx['recipient_phone']) ?>" 
                  data-alamat="<?= esc($tx['shipping_address']) ?>" 
                  data-catatan="<?= esc($tx['catatan_pengiriman'] ?: '-') ?>"
                  data-metode="<?= esc($tx['metode_pembayaran']) ?>"
                  data-bukti="<?= esc($tx['bukti_transfer']) ?>"
                  data-details='<?= json_encode($tx['details'] ?? []) ?>'>
                  <i class="ti ti-search"></i> Lihat
                </button>
                <?php if ($tx['status_pembayaran'] === 'Menunggu Verifikasi' || $tx['status_pembayaran'] === 'Menunggu Pembayaran'): ?>
                  <a href="<?= base_url('admin/transaksi/verifikasi/' . $tx['id']) ?>" class="btn btn-sm btn-success py-1 px-2 text-white"><i class="ti ti-check"></i> Verifikasi</a>
                  <a href="#" class="btn btn-sm btn-danger py-1 px-2 text-white" onclick="window.confirmDelete('<?= base_url('admin/transaksi/batal/' . $tx['id']) ?>', 'Apakah Anda yakin ingin membatalkan transaksi ini?'); return false;"><i class="ti ti-x"></i> Batalkan</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi masuk.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="modalDetailTransaksi" tabindex="-1" aria-labelledby="modalDetailTransaksiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm" style="border-radius: 12px;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalDetailTransaksiLabel"><i class="ti ti-receipt text-primary me-2"></i>Detail Pengiriman Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="small text-muted d-block mb-1">ID Transaksi</label>
          <div class="fw-bold fs-6 text-dark" id="detail-tx-id">#TRX-000</div>
        </div>
        <div class="mb-3">
          <label class="small text-muted d-block mb-1">Nama Penerima</label>
          <div class="fw-bold text-dark" id="detail-tx-penerima"></div>
        </div>
        <div class="mb-3">
          <label class="small text-muted d-block mb-1">Nomor Telepon</label>
          <div class="fw-bold text-dark" id="detail-tx-telepon"></div>
        </div>
        <div class="mb-3">
          <label class="small text-muted d-block mb-1">Alamat Pengiriman</label>
          <div class="text-dark mb-3" id="detail-tx-alamat" style="line-height: 1.5;"></div>
        </div>
        <div class="mb-3">
          <label class="small text-muted d-block mb-2">Daftar Barang Belanjaan</label>
          <div id="detail-tx-products" class="p-2 border rounded-2 bg-light mb-3" style="max-height: 200px; overflow-y: auto;">
            <!-- Injected by JS -->
          </div>
        </div>
        <div class="mb-3">
          <label class="small text-muted d-block mb-1">Metode Pembayaran</label>
          <div class="fw-bold text-dark text-capitalize" id="detail-tx-metode"></div>
        </div>
        <div class="mb-3 d-none" id="container-bukti-transfer">
          <label class="small text-muted d-block mb-1">Bukti Transfer</label>
          <div id="detail-tx-bukti-status" class="text-danger small fw-bold mb-2"></div>
          <a id="detail-tx-bukti-link" href="#" target="_blank">
            <img id="detail-tx-bukti-img" src="" alt="Bukti Transfer" class="img-thumbnail" style="max-height: 250px; display: block; border-radius: 6px;">
          </a>
        </div>
        <div class="mb-0">
          <label class="small text-muted d-block mb-1">Catatan Tambahan</label>
          <div class="text-dark fst-italic bg-light p-2 rounded-2" id="detail-tx-catatan"></div>
        </div>
      </div>
      <div class="modal-footer border-0 bg-light p-3">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" style="border-radius: 6px;">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const detailButtons = document.querySelectorAll('.btn-detail-tx');
  detailButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('detail-tx-id').textContent = '#' + this.dataset.id;
      document.getElementById('detail-tx-penerima').textContent = this.dataset.penerima;
      document.getElementById('detail-tx-telepon').textContent = this.dataset.telepon;
      document.getElementById('detail-tx-alamat').textContent = this.dataset.alamat;
      document.getElementById('detail-tx-catatan').textContent = this.dataset.catatan;
      
      const metode = this.dataset.metode;
      document.getElementById('detail-tx-metode').textContent = metode === 'auto' ? 'Otomatis (Midtrans)' : 'Manual (Transfer Bank)';

      const containerBukti = document.getElementById('container-bukti-transfer');
      const imgBukti = document.getElementById('detail-tx-bukti-img');
      const linkBukti = document.getElementById('detail-tx-bukti-link');
      const statusBukti = document.getElementById('detail-tx-bukti-status');

      // Inject products list
      const productsContainer = document.getElementById('detail-tx-products');
      productsContainer.innerHTML = '';
      const details = JSON.parse(this.dataset.details || '[]');
      if (details.length > 0) {
        details.forEach(item => {
          const div = document.createElement('div');
          div.className = 'd-flex justify-content-between mb-1 py-1 border-bottom border-dashed small';
          div.innerHTML = `<span><strong>${item.produk_nama}</strong></span> <span class="text-secondary">${item.qty} ${item.satuan}</span>`;
          productsContainer.appendChild(div);
        });
      } else {
        productsContainer.innerHTML = '<span class="text-muted small">Tidak ada rincian barang.</span>';
      }

      if (metode === 'manual') {
        containerBukti.classList.remove('d-none');
        const buktiFile = this.dataset.bukti;
        if (buktiFile && buktiFile !== '' && buktiFile !== 'null') {
          statusBukti.textContent = '';
          statusBukti.classList.add('d-none');
          imgBukti.src = '<?= base_url('uploads/bukti') ?>/' + buktiFile;
          linkBukti.href = '<?= base_url('uploads/bukti') ?>/' + buktiFile;
          imgBukti.style.display = 'block';
        } else {
          statusBukti.textContent = 'Belum mengunggah bukti transfer';
          statusBukti.classList.remove('d-none');
          imgBukti.style.display = 'none';
          linkBukti.href = '#';
        }
      } else {
        containerBukti.classList.add('d-none');
      }
      
      showModal('modalDetailTransaksi');
    });
  });
});
</script>
<?= $this->endSection() ?>
