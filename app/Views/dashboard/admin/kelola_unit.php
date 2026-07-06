<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Kelola Unit Bisnis</h1>
      <p class="text-muted small">Manajemen kelompok tani dan lini bisnis sirkular PT Parung Hijau Perkasa.</p>
    </div>
  </div>
</div>

<div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h5 class="fw-bold text-dark mb-0"><i class="ti ti-building me-2 text-primary"></i>Kelompok Bisnis Aktif</h5>
    <button class="btn btn-sm btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahUnit">
      <i class="ti ti-plus me-1"></i> Tambah Unit
    </button>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
          <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Nama Unit</th>
          <th style="font-weight: 600; color: #64748b;">Wilayah Operasional</th>
          <th style="font-weight: 600; color: #64748b;">Komoditas Utama</th>
          <th style="font-weight: 600; color: #64748b;">Kapasitas Bulanan</th>
          <th class="text-end pe-3" style="font-weight: 600; color: #64748b;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($units)): ?>
          <?php foreach ($units as $unit): ?>
            <tr style="border-bottom: 1px solid #f8fafc;">
              <td class="ps-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 36px; height: 36px; font-weight: 600;"><?= strtoupper(substr($unit['nama'], 0, 2)) ?></div>
                  <strong><?= esc($unit['nama']) ?></strong>
                </div>
              </td>
              <td><?= esc($unit['wilayah']) ?></td>
              <td><span class="badge rounded-pill px-3 py-1" style="background-color: #22c55e; color: #ffffff;"><?= esc($unit['komoditas']) ?></span></td>
              <td><?= esc($unit['kapasitas']) ?></td>
              <td class="text-end pe-3">
                <button class="btn btn-sm btn-light border py-1 px-2 text-secondary btn-edit-unit" 
                  data-id="<?= $unit['id'] ?>" 
                  data-nama="<?= esc($unit['nama']) ?>" 
                  data-wilayah="<?= esc($unit['wilayah']) ?>" 
                  data-komoditas="<?= esc($unit['komoditas']) ?>" 
                  data-kapasitas="<?= esc($unit['kapasitas']) ?>"
                  data-tagline="<?= esc($unit['tagline']) ?>"
                  data-alamat="<?= esc($unit['alamat']) ?>"
                  data-phone="<?= esc($unit['phone']) ?>"
                  data-jam="<?= esc($unit['jam']) ?>"
                  data-maps="<?= esc($unit['maps']) ?>"
                  data-deskripsi="<?= esc($unit['deskripsi']) ?>"
                  data-foto="<?= esc($unit['foto_sampul']) ?>"
                  data-gallery="<?= esc($unit['dokumentasi']) ?>"><i class="ti ti-pencil"></i> Edit</button>
                <button class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="window.confirmDelete('<?= base_url('admin/unit/hapus/' . $unit['id']) ?>', 'Apakah Anda yakin ingin menghapus unit bisnis <?= esc($unit['nama']) ?> beserta seluruh data detailnya?')"><i class="ti ti-trash"></i> Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Belum ada unit bisnis terdaftar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Unit -->
<!-- Modal Tambah Unit -->
<div class="modal fade" id="modalTambahUnit" tabindex="-1" aria-labelledby="modalTambahUnitLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalTambahUnitLabel"><i class="ti ti-building text-primary me-2"></i>Tambah Unit Bisnis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('admin/unit/tambah') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body p-4" style="min-height: 520px;">
          <div class="row">
            <!-- Kolom Kiri: Info Unit -->
            <div class="col-lg-6 pe-lg-4 mb-4 mb-lg-0" style="border-right: 1px solid #f1f5f9;">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-info-circle me-1"></i>Informasi Unit</h6>
              
              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-nama">Nama Unit Bisnis</label>
                  <input type="text" class="form-control form-control-sm" id="add-nama" name="nama" placeholder="e.g. Melon Golden" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-tagline">Tagline Detail (Handwritten)</label>
                  <input type="text" class="form-control form-control-sm" id="add-tagline" name="tagline" placeholder="e.g. Budidaya Melon Premium" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-wilayah">Wilayah Operasional</label>
                  <input type="text" class="form-control form-control-sm" id="add-wilayah" name="wilayah" placeholder="e.g. Kec. Ciampea, Bogor" required>
                </div>
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-komoditas">Komoditas Utama</label>
                  <input type="text" class="form-control form-control-sm" id="add-komoditas" name="komoditas" placeholder="e.g. Melon Golden" required>
                </div>
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-kapasitas">Kapasitas Bulanan</label>
                  <input type="text" class="form-control form-control-sm" id="add-kapasitas" name="kapasitas" placeholder="e.g. 2,000 Pcs" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-alamat">Alamat Lengkap</label>
                  <input type="text" class="form-control form-control-sm" id="add-alamat" name="alamat" placeholder="Jl. Raya Kp. Baru No. 12" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-phone">Nomor Telepon Unit</label>
                  <input type="text" class="form-control form-control-sm" id="add-phone" name="phone" placeholder="+62 251 xxxx" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-hari">Hari Operasional</label>
                  <input type="text" class="form-control form-control-sm" id="add-hari" name="hari" placeholder="e.g. Senin – Jumat" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-maps">Link Google Maps</label>
                  <input type="url" class="form-control form-control-sm" id="add-maps" name="maps" placeholder="https://maps.google.com/?q=..." required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-jam-buka">Jam Buka</label>
                  <input type="time" class="form-control form-control-sm" id="add-jam-buka" name="jam_buka" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="add-jam-tutup">Jam Tutup</label>
                  <input type="time" class="form-control form-control-sm" id="add-jam-tutup" name="jam_tutup" required>
                </div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="add-deskripsi">Deskripsi Detail Profil</label>
                <textarea class="form-control form-control-sm" id="add-deskripsi" name="deskripsi" rows="4" placeholder="Tuliskan latar belakang dan komitmen unit bisnis ini..." required></textarea>
              </div>
            </div>

            <!-- Kolom Kanan: Foto & Galeri -->
            <div class="col-lg-6 ps-lg-4">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-photo me-1"></i>Foto & Dokumentasi</h6>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="add-foto-sampul">Foto Sampul / Hero Banner</label>
                <input type="file" class="form-control form-control-sm" id="add-foto-sampul" name="foto_sampul" accept="image/*">
                <div class="form-text small mb-2">Gambar utama yang ditampilkan di halaman beranda.</div>
                <div id="add-foto-preview" style="max-width: 150px; border-radius: 8px; overflow: hidden; display: none;"></div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="add-gallery-unit">Dokumentasi Galeri (Multiple)</label>
                <input type="file" class="form-control form-control-sm" id="add-gallery-unit" name="gallery[]" multiple accept="image/*">
                <div class="form-text small mb-2">Pilih beberapa foto sekaligus. Geser (drag) untuk mengatur urutan.</div>
                <div id="add-gallery-preview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                <input type="hidden" id="add-gallery-order" name="gallery_order" value="">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light p-3">
          <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px;">Simpan Unit Bisnis</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Unit -->
<div class="modal fade" id="modalEditUnit" tabindex="-1" aria-labelledby="modalEditUnitLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalEditUnitLabel"><i class="ti ti-pencil text-primary me-2"></i>Edit Unit Bisnis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-unit" data-base-url="<?= base_url() ?>" action="" method="post" enctype="multipart/form-data">
        <div class="modal-body p-4" style="min-height: 520px;">
          <input type="hidden" id="edit-id">

          <div class="row">
            <!-- Kolom Kiri: Info Unit -->
            <div class="col-lg-6 pe-lg-4 mb-4 mb-lg-0" style="border-right: 1px solid #f1f5f9;">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-info-circle me-1"></i>Informasi Unit</h6>
              
              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-nama">Nama Unit Bisnis</label>
                  <input type="text" class="form-control form-control-sm" id="edit-nama" name="nama" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-tagline">Tagline Detail (Handwritten)</label>
                  <input type="text" class="form-control form-control-sm" id="edit-tagline" name="tagline" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-wilayah">Wilayah Operasional</label>
                  <input type="text" class="form-control form-control-sm" id="edit-wilayah" name="wilayah" required>
                </div>
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-komoditas">Komoditas Utama</label>
                  <input type="text" class="form-control form-control-sm" id="edit-komoditas" name="komoditas" required>
                </div>
                <div class="col-md-4 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-kapasitas">Kapasitas Bulanan</label>
                  <input type="text" class="form-control form-control-sm" id="edit-kapasitas" name="kapasitas" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-alamat">Alamat Lengkap</label>
                  <input type="text" class="form-control form-control-sm" id="edit-alamat" name="alamat" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-phone">Nomor Telepon Unit</label>
                  <input type="text" class="form-control form-control-sm" id="edit-phone" name="phone" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-hari">Hari Operasional</label>
                  <input type="text" class="form-control form-control-sm" id="edit-hari" name="hari" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-maps">Link Google Maps</label>
                  <input type="url" class="form-control form-control-sm" id="edit-maps" name="maps" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-jam-buka">Jam Buka</label>
                  <input type="time" class="form-control form-control-sm" id="edit-jam-buka" name="jam_buka" required>
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label small fw-bold text-secondary" for="edit-jam-tutup">Jam Tutup</label>
                  <input type="time" class="form-control form-control-sm" id="edit-jam-tutup" name="jam_tutup" required>
                </div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="edit-deskripsi">Deskripsi Detail Profil</label>
                <textarea class="form-control form-control-sm" id="edit-deskripsi" name="deskripsi" rows="4" required></textarea>
              </div>
            </div>

            <!-- Kolom Kanan: Foto & Galeri -->
            <div class="col-lg-6 ps-lg-4">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-photo me-1"></i>Foto & Dokumentasi</h6>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="edit-foto-sampul">Foto Sampul / Hero Banner</label>
                <input type="file" class="form-control form-control-sm" id="edit-foto-sampul" name="foto_sampul" accept="image/*">
                <div class="form-text small mb-2">Kosongkan jika tidak ingin mengganti foto sampul saat ini.</div>
                <div id="edit-foto-preview" style="max-width: 150px; border-radius: 8px; overflow: hidden;"></div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="edit-gallery-unit">Kelola Foto Galeri (Multiple)</label>
                <input type="file" class="form-control form-control-sm" id="edit-gallery-unit" name="gallery[]" multiple accept="image/*">
                <div class="form-text small mb-2">Tambah, hapus, atau geser (drag) untuk mengatur urutan.</div>
                <div id="edit-gallery-preview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                <input type="hidden" id="edit-gallery-order" name="gallery_order" value="">
              </div>
            </div>
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


<?= $this->endSection() ?>
