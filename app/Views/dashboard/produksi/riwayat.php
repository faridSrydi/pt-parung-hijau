<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Update & Riwayat Produksi</h1>
      <p class="text-muted small">Kelola seluruh riwayat hasil panen, pantau kualitas produk, dan lakukan pembaruan data jika diperlukan.</p>
    </div>
  </div>
</div>

<!-- Filters and Table -->
<div class="row">
  <div class="col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      
      <!-- Filter Bar -->
      <div class="row g-3 align-items-center justify-content-between mb-4">
        <div class="col-lg-8 col-12 d-flex flex-wrap gap-2">
          <!-- Search input -->
          <div class="input-group input-group-sm border rounded-2" style="max-width: 250px; background: #fff;">
            <span class="input-group-text bg-transparent border-0 text-muted"><i class="ti ti-search"></i></span>
            <input type="text" id="search-komoditas" class="form-control border-0 bg-transparent px-0" placeholder="Cari komoditas...">
          </div>
          
          <!-- Filter Unit Bisnis -->
          <select id="filter-unit" class="form-select form-control-sm border rounded-2" style="max-width: 200px; height: 38px;">
            <option value="">Semua Kelompok Tani</option>
            <option value="sungrow">Sungrow (Pisang)</option>
            <option value="chicken">Adiluhung Chicken</option>
            <option value="patin">Adiluhung Patin</option>
            <option value="waste">Waste Management</option>
          </select>

          <!-- Filter Kualitas -->
          <select id="filter-kualitas" class="form-select form-control-sm border rounded-2" style="max-width: 150px; height: 38px;">
            <option value="">Semua Kualitas</option>
            <option value="grade_a">Grade A</option>
            <option value="grade_b">Grade B</option>
            <option value="grade_c">Grade C</option>
          </select>
        </div>

        <div class="col-lg-4 col-12 text-lg-end d-flex justify-content-lg-end gap-2">
          <button class="btn btn-sm btn-light border px-3 py-2 small" onclick="location.reload();"><i class="ti ti-refresh me-1"></i> Refresh</button>
          <a href="<?= base_url('produksi/input') ?>" class="btn btn-sm btn-primary px-3 py-2 small"><i class="ti ti-plus me-1"></i> Panen Baru</a>
        </div>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9; background-color: #f8fafc;">
              <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Tanggal</th>
              <th style="font-weight: 600; color: #64748b;">Produk Hasil Panen</th>
              <th style="font-weight: 600; color: #64748b;">Kelompok Tani / Unit</th>
              <th style="font-weight: 600; color: #64748b;">Volume Panen</th>
              <th style="font-weight: 600; color: #64748b;">Kualitas</th>
              <th style="font-weight: 600; color: #64748b;">Catatan</th>
              <th class="text-end pe-3" style="font-weight: 600; color: #64748b;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($logs)): ?>
              <?php foreach ($logs as $log): ?>
                <tr class="panen-row" 
                    data-produk="<?= esc(strtolower($log['produk_nama'])) ?>" 
                    data-unit="<?= esc($log['unit_bisnis_id']) ?>" 
                    data-kualitas="<?= esc($log['kualitas']) ?>"
                    style="border-bottom: 1px solid #f8fafc;">
                  <td class="ps-3"><?= date('d M Y', strtotime($log['tanggal_panen'])) ?></td>
                  <td><strong><?= esc($log['produk_nama']) ?></strong></td>
                  <td><?= esc(ucfirst($log['unit_bisnis_id'])) ?></td>
                  <td><?= esc($log['volume']) ?> <?= esc($log['satuan']) ?></td>
                  <td>
                    <?php if ($log['kualitas'] === 'grade_a'): ?>
                      <span class="badge" style="background-color: rgba(12, 138, 95, 0.1); color: #0c8a5f !important; padding: 5px 8px; font-weight: 600;">Grade A</span>
                    <?php elseif ($log['kualitas'] === 'grade_b'): ?>
                      <span class="badge" style="background-color: rgba(182, 138, 88, 0.1); color: #b68a58 !important; padding: 5px 8px; font-weight: 600;">Grade B</span>
                    <?php else: ?>
                      <span class="badge" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d !important; padding: 5px 8px; font-weight: 600;"><?= esc(ucfirst($log['kualitas'])) ?></span>
                    <?php endif; ?>
                  </td>
                  <td><span class="text-muted small"><?= esc($log['catatan'] ?: '-') ?></span></td>
                  <td class="text-end pe-3">
                    <button class="btn btn-sm btn-light border py-1 px-2 text-secondary btn-edit-panen" 
                      data-id="<?= $log['id'] ?>" 
                      data-tanggal="<?= esc($log['tanggal_panen']) ?>"
                      data-produk="<?= esc($log['produk_id']) ?>"
                      data-unit="<?= esc($log['unit_bisnis_id']) ?>"
                      data-jumlah="<?= esc($log['volume']) ?>"
                      data-kualitas="<?= esc($log['kualitas']) ?>"
                      data-catatan="<?= esc($log['catatan']) ?>"><i class="ti ti-pencil"></i> Edit</button>
                    <button type="button" 
                            onclick="window.confirmDelete('<?= base_url('produksi/hapus/' . $log['id']) ?>', 'Apakah Anda yakin ingin menghapus data panen ini? Tindakan ini akan mengembalikan stok produk terkait.')" 
                            class="btn btn-sm btn-light border py-1 px-2 text-danger ms-1"><i class="ti ti-trash"></i> Hapus</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat hasil panen.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top small text-muted">
        <span id="entries-count-text">Menampilkan <?= count($logs) ?> entri data</span>
      </div>

    </div>
  </div>
</div>

<!-- Modal Edit Panen -->
<div class="modal fade" id="modalEditPanen" tabindex="-1" aria-labelledby="modalEditPanenLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalEditPanenLabel"><i class="ti ti-pencil text-primary me-2"></i>Edit Data Produksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditPanen" action="" method="post">
        <div class="modal-body p-4">
          <input type="hidden" id="edit-id" name="id">
          
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-unit-bisnis">Unit Bisnis / Kelompok Tani</label>
            <select class="form-select form-control" id="edit-unit-bisnis" name="unit_bisnis_id" style="height: 44px; border-radius: 6px;" required>
              <option value="">-- Pilih Unit Bisnis --</option>
              <option value="sungrow">Sungrow (Pisang Cavendish)</option>
              <option value="chicken">Adiluhung Chicken (Unggas & Telur)</option>
              <option value="patin">Adiluhung Patin (Perikanan)</option>
              <option value="waste">Waste Management (Kompos & Pakan)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-produk">Produk Hasil Panen</label>
            <select class="form-select form-control" id="edit-produk" name="produk_id" style="height: 44px; border-radius: 6px;" required>
              <option value="">-- Pilih Produk --</option>
              <?php foreach ($products as $prod): ?>
                <option value="<?= esc($prod['id']) ?>" data-unit="<?= esc($prod['unit_bisnis_id']) ?>" data-satuan="<?= esc($prod['satuan']) ?>"><?= esc($prod['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-jumlah">Volume Panen</label>
              <input type="number" class="form-control" id="edit-jumlah" name="volume" min="1" style="height: 44px; border-radius: 6px;" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-kualitas">Kualitas / Grade</label>
              <select class="form-select form-control" id="edit-kualitas" name="kualitas" style="height: 44px; border-radius: 6px;" required>
                <option value="grade_a">Grade A (Sangat Baik)</option>
                <option value="grade_b">Grade B (Baik)</option>
                <option value="grade_c">Grade C (Cukup)</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-tanggal">Tanggal Produksi</label>
            <input type="date" class="form-control" id="edit-tanggal" name="tanggal_panen" style="height: 44px; border-radius: 6px;" required>
          </div>

          <div class="mb-0">
            <label class="form-label small fw-bold text-secondary" for="edit-catatan">Catatan / Kondisi Lapangan</label>
            <textarea class="form-control" id="edit-catatan" name="catatan" rows="3" style="border-radius: 6px;"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light p-3">
          <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px;">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const editButtons = document.querySelectorAll('.btn-edit-panen');
  const unitSelect = document.getElementById('edit-unit-bisnis');
  const productSelect = document.getElementById('edit-produk');
  const editForm = document.getElementById('formEditPanen');

  // Keep a copy of all initial product options
  const initialProducts = Array.from(productSelect.options);

  function filterEditProducts(selectedUnit, selectedProduct = '') {
    productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
    if (selectedUnit) {
      initialProducts.forEach(opt => {
        if (!opt.value) return;
        const unit = opt.getAttribute('data-unit');
        if (unit === selectedUnit) {
          productSelect.appendChild(opt.cloneNode(true));
        }
      });
    } else {
      initialProducts.forEach(opt => {
        if (opt.value) productSelect.appendChild(opt.cloneNode(true));
      });
    }
    if (selectedProduct) {
      productSelect.value = selectedProduct;
    }
  }

  unitSelect.addEventListener('change', function() {
    filterEditProducts(this.value);
  });

  editButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      document.getElementById('edit-id').value = id;
      document.getElementById('edit-unit-bisnis').value = this.dataset.unit;
      
      // Filter first, then select the value
      filterEditProducts(this.dataset.unit, this.dataset.produk);
      
      document.getElementById('edit-jumlah').value = this.dataset.jumlah;
      document.getElementById('edit-kualitas').value = this.dataset.kualitas;
      document.getElementById('edit-tanggal').value = this.dataset.tanggal;
      document.getElementById('edit-catatan').value = this.dataset.catatan;
      
      // Update the form action url
      editForm.action = '<?= base_url('produksi/update') ?>/' + id;
      
      showModal('modalEditPanen');
    });
  });

  // Live Filtering Logic for search & dropdowns
  const searchInput = document.getElementById('search-komoditas');
  const filterUnit = document.getElementById('filter-unit');
  const filterKualitas = document.getElementById('filter-kualitas');
  const panenRows = document.querySelectorAll('.panen-row');
  const entriesCountText = document.getElementById('entries-count-text');

  function filterTable() {
    const query = searchInput.value.toLowerCase().trim();
    const selectedUnit = filterUnit.value;
    const selectedKualitas = filterKualitas.value;
    let visibleCount = 0;

    panenRows.forEach(row => {
      const produk = row.getAttribute('data-produk');
      const unit = row.getAttribute('data-unit');
      const kualitas = row.getAttribute('data-kualitas');

      const matchesSearch = produk.includes(query);
      const matchesUnit = !selectedUnit || unit === selectedUnit;
      const matchesKualitas = !selectedKualitas || kualitas === selectedKualitas;

      if (matchesSearch && matchesUnit && matchesKualitas) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    if (entriesCountText) {
      entriesCountText.textContent = `Menampilkan ${visibleCount} dari ${panenRows.length} entri data`;
    }

    let emptyRow = document.getElementById('empty-filter-row');
    if (visibleCount === 0) {
      if (!emptyRow) {
        emptyRow = document.createElement('tr');
        emptyRow.id = 'empty-filter-row';
        emptyRow.innerHTML = `<td colspan="7" class="text-center text-muted py-4">Tidak ada data panen yang cocok dengan filter.</td>`;
        document.querySelector('.table tbody').appendChild(emptyRow);
      }
    } else {
      if (emptyRow) {
        emptyRow.remove();
      }
    }
  }

  if (searchInput && filterUnit && filterKualitas) {
    searchInput.addEventListener('input', filterTable);
    filterUnit.addEventListener('change', filterTable);
    filterKualitas.addEventListener('change', filterTable);
  }
});
</script>
<?= $this->endSection() ?>
