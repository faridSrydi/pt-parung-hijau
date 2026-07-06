<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Input Hasil Produksi</h1>
      <p class="text-muted small">Tambahkan pencatatan hasil panen baru dari kelompok tani untuk memperbarui stok barang secara real-time.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Left Side: Guidance and Stats Summary -->
  <div class="col-lg-4 col-12">
    <div class="card border-0 p-4 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-info-circle text-primary me-2"></i>Panduan Pengisian</h5>
      <ul class="list-unstyled mb-0 small text-muted lh-lg">
        <li class="mb-3 d-flex gap-2">
          <i class="ti ti-circle-number-1 text-primary fs-5"></i>
          <span><strong>Pilih Unit Bisnis:</strong> Pastikan Anda memilih kelompok tani atau unit bisnis yang sesuai dengan jenis komoditas.</span>
        </li>
        <li class="mb-3 d-flex gap-2">
          <i class="ti ti-circle-number-2 text-primary fs-5"></i>
          <span><strong>Pilih Produk & Volume:</strong> Masukkan jenis komoditas hasil panen beserta volume total (kg, ekor, sisir, dll).</span>
        </li>
        <li class="mb-3 d-flex gap-2">
          <i class="ti ti-circle-number-3 text-primary fs-5"></i>
          <span><strong>Kualitas & Catatan:</strong> Tentukan kualitas standar (Grade A/B/C) dan tulis catatan lapangan jika ada kendala cuaca atau logistik.</span>
        </li>
      </ul>
      <div class="mt-4 p-3 bg-light rounded-3">
        <span class="small text-secondary d-block mb-1">Informasi Stok Otomatis</span>
        <p class="small text-muted mb-0">Setiap data panen yang disimpan akan secara otomatis terakumulasi ke dalam inventaris gudang distribusi pusat.</p>
      </div>
    </div>
  </div>

  <!-- Right Side: The Form -->
  <div class="col-lg-8 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-3"><i class="ti ti-edit text-primary me-2"></i>Form Formulir Pencatatan Panen</h5>
      <p class="text-muted small mb-4">Input data panen baru di bawah ini secara akurat.</p>
      
      <form action="<?= base_url('produksi/input') ?>" method="post">
        <!-- Unit Bisnis -->
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary" for="unit-bisnis">Unit Bisnis / Kelompok Tani</label>
          <select class="form-select form-control" id="unit-bisnis" name="unit_bisnis_id" style="height: 44px; border-radius: 6px;" required>
            <option value="">-- Pilih Unit Bisnis --</option>
            <option value="sungrow">Sungrow (Pisang Cavendish)</option>
            <option value="chicken">Adiluhung Chicken (Unggas & Telur)</option>
            <option value="patin">Adiluhung Patin (Perikanan)</option>
            <option value="waste">Waste Management (Kompos & Pakan)</option>
          </select>
        </div>

        <!-- Produk -->
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary" for="produk">Produk Hasil Panen</label>
          <select class="form-select form-control" id="produk" name="produk_id" style="height: 44px; border-radius: 6px;" required>
            <option value="">-- Pilih Produk --</option>
            <?php foreach ($products as $prod): ?>
              <option value="<?= esc($prod['id']) ?>" data-unit="<?= esc($prod['unit_bisnis_id']) ?>" data-satuan="<?= esc($prod['satuan']) ?>"><?= esc($prod['nama']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Jumlah & Kualitas -->
        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label small fw-bold text-secondary" for="jumlah">Volume Panen</label>
            <div class="input-group">
              <input type="number" class="form-control" id="jumlah" name="volume" placeholder="e.g. 50" min="1" style="height: 44px; border-top-left-radius: 6px; border-bottom-left-radius: 6px;" required>
              <span class="input-group-text bg-light text-secondary fw-bold" id="volume-unit-label" style="height: 44px; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Satuan</span>
            </div>
          </div>
          <div class="col-6">
            <label class="form-label small fw-bold text-secondary" for="kualitas">Kualitas / Grade</label>
            <select class="form-select form-control" id="kualitas" name="kualitas" style="height: 44px; border-radius: 6px;" required>
              <option value="grade_a">Grade A (Sangat Baik)</option>
              <option value="grade_b">Grade B (Baik)</option>
              <option value="grade_c">Grade C (Cukup)</option>
            </select>
          </div>
        </div>

        <!-- Tanggal -->
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary" for="tanggal">Tanggal Produksi</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal_panen" value="<?= date('Y-m-d') ?>" style="height: 44px; border-radius: 6px;" required>
        </div>

        <!-- Catatan -->
        <div class="mb-4">
          <label class="form-label small fw-bold text-secondary" for="catatan">Catatan / Kondisi Lapangan</label>
          <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Kondisi cuaca, tingkat kesegaran, dll." style="border-radius: 6px;"></textarea>
        </div>

        <div class="d-flex gap-2">
          <button type="button" onclick="window.history.back();" class="btn btn-light border px-4 py-2 fw-bold" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary flex-grow-1 py-2 fw-bold" style="border-radius: 6px;">Simpan & Update Stok</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const unitSelect = document.getElementById('unit-bisnis');
  const productSelect = document.getElementById('produk');
  const unitLabel = document.getElementById('volume-unit-label');

  // Keep a copy of all initial product options
  const initialProducts = Array.from(productSelect.options);

  unitSelect.addEventListener('change', function() {
    const selectedUnit = this.value;
    
    // Clear and reset product options
    productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
    
    initialProducts.forEach(opt => {
      if (!opt.value) return;
      const unit = opt.getAttribute('data-unit');
      if (!selectedUnit || unit === selectedUnit) {
        productSelect.appendChild(opt.cloneNode(true));
      }
    });
    
    // Reset unit label
    unitLabel.textContent = 'Satuan';
  });

  productSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption && selectedOption.value) {
      unitLabel.textContent = selectedOption.getAttribute('data-satuan') || 'Satuan';
    } else {
      unitLabel.textContent = 'Satuan';
    }
  });
});
</script>
<?= $this->endSection() ?>
