<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Kelola Produk</h1>
      <p class="text-muted small">Kelola penawaran produk, stok, dan harga jual produk segar Parung Hijau.</p>
    </div>
  </div>
</div>

<div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h5 class="fw-bold text-dark mb-0"><i class="ti ti-box-seam me-2 text-primary"></i>Katalog Produk Aktif</h5>
    <button class="btn btn-sm btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahProduk"><i class="ti ti-plus me-1"></i> Tambah Produk</button>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr style="border-bottom: 2px solid #f1f5f9;">
          <th style="font-weight: 600; color: #64748b;">Nama Produk</th>
          <th style="font-weight: 600; color: #64748b;">Kategori</th>
          <th style="font-weight: 600; color: #64748b;">Harga Jual</th>
          <th style="font-weight: 600; color: #64748b;">Stok Tersedia</th>
          <th style="font-weight: 600; color: #64748b;">Status</th>
          <th class="text-end" style="font-weight: 600; color: #64748b;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $prod): ?>
            <?php if ($prod['parent_id'] === null && $prod['stok'] == 0 && $prod['id'] === 'sungrow-cavendish') continue; ?>
            <tr style="border-bottom: 1px solid #f8fafc;">
              <td><strong><?= esc($prod['nama']) ?></strong></td>
              <td><?= esc(ucfirst($prod['unit_bisnis_id'])) ?></td>
              <td>Rp <?= number_format($prod['harga'], 0, ',', '.') ?> / <?= esc($prod['satuan']) ?></td>
              <td><?= esc($prod['stok']) ?> <?= esc($prod['satuan']) ?></td>
              <td>
                <?php if ($prod['stok'] > 10): ?>
                  <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Ready</span>
                <?php elseif ($prod['stok'] > 0): ?>
                  <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Stok Menipis</span>
                <?php else: ?>
                  <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Habis</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <button class="btn btn-sm btn-light border py-1 px-2 text-secondary btn-edit-produk" 
                  data-id="<?= $prod['id'] ?>"
                  data-nama="<?= esc($prod['nama']) ?>"
                  data-unit="<?= esc($prod['unit_bisnis_id']) ?>"
                  data-harga="<?= esc($prod['harga']) ?>"
                  data-satuan="<?= esc($prod['satuan']) ?>"
                  data-stok="<?= esc($prod['stok']) ?>"
                  data-parent="<?= esc($prod['parent_id']) ?>"
                  data-singkat="<?= esc($prod['deskripsi_singkat']) ?>"
                  data-lengkap="<?= esc($prod['deskripsi_lengkap']) ?>"
                  data-foto="<?= esc($prod['image_path']) ?>"
                  data-gallery="<?= esc($prod['gallery']) ?>"><i class="ti ti-pencil"></i> Edit</button>
                <button class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="window.confirmDelete('<?= base_url('admin/produk/hapus/' . $prod['id']) ?>', 'Apakah Anda yakin ingin menghapus produk <?= esc($prod['nama']) ?>?')"><i class="ti ti-trash"></i> Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">Belum ada produk terdaftar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalTambahProdukLabel"><i class="ti ti-plus text-primary me-2"></i>Tambah Produk Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('admin/produk/tambah') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body p-4" style="min-height: 520px;">
          <div class="row">
            <!-- Kolom Kiri: Info Produk -->
            <div class="col-lg-6 pe-lg-4 mb-4 mb-lg-0" style="border-right: 1px solid #f1f5f9;">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-info-circle me-1"></i>Informasi Produk</h6>
              
              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="add-nama">Nama Produk</label>
                <input type="text" class="form-control form-control-sm" id="add-nama" name="nama" placeholder="e.g. Pisang Cavendish Grade A" required>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <label class="form-label small fw-bold text-secondary" for="add-unit">Unit Bisnis</label>
                  <select class="form-select form-select-sm" id="add-unit" name="unit_bisnis_id" required>
                    <option value="">-- Pilih Unit --</option>
                    <?php foreach ($units as $unit): ?>
                      <option value="<?= esc($unit['id']) ?>"><?= esc($unit['nama']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label small fw-bold text-secondary" for="add-parent">Parent (Varian Dari)</label>
                  <select class="form-select form-select-sm" id="add-parent" name="parent_id">
                    <option value="">-- Produk Utama --</option>
                    <?php foreach ($products as $p): ?>
                      <?php if ($p['parent_id'] === null): ?>
                        <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="add-harga">Harga Jual</label>
                  <input type="number" class="form-control form-control-sm" id="add-harga" name="harga" placeholder="35000" required>
                </div>
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="add-satuan">Satuan</label>
                  <select class="form-select form-select-sm" id="add-satuan" name="satuan" required>
                    <option value="Sisir">Sisir</option>
                    <option value="Kg">Kg</option>
                    <option value="Ekor">Ekor</option>
                    <option value="Pack">Pack</option>
                  </select>
                </div>
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="add-stok">Stok Awal</label>
                  <input type="number" class="form-control form-control-sm" id="add-stok" name="stok" placeholder="100" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="add-singkat">Deskripsi Singkat</label>
                <input type="text" class="form-control form-control-sm" id="add-singkat" name="deskripsi_singkat" placeholder="Satu baris deskripsi..." required>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="add-lengkap">Deskripsi Lengkap</label>
                <textarea class="form-control form-control-sm" id="add-lengkap" name="deskripsi_lengkap" rows="5" placeholder="Penjelasan lengkap detail produk..." required></textarea>
              </div>
            </div>

            <!-- Kolom Kanan: Foto & Galeri -->
            <div class="col-lg-6 ps-lg-4">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-photo me-1"></i>Foto Produk</h6>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="add-foto-produk">Foto Utama Produk</label>
                <input type="file" class="form-control form-control-sm" id="add-foto-produk" name="foto_produk" accept="image/*">
                <div class="form-text small mb-2">Gambar utama yang tampil di katalog.</div>
                <div id="add-foto-preview" style="max-width: 150px; border-radius: 8px; overflow: hidden; display: none;"></div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="add-gallery-produk">Galeri Produk (Multiple)</label>
                <input type="file" class="form-control form-control-sm" id="add-gallery-produk" name="gallery_produk[]" multiple accept="image/*">
                <div class="form-text small mb-2">Pilih beberapa foto. Geser (drag) untuk mengatur urutan.</div>
                <div id="add-gallery-preview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                <input type="hidden" id="add-gallery-order" name="gallery_order" value="">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light p-3">
          <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px;">Simpan Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalEditProdukLabel"><i class="ti ti-pencil text-primary me-2"></i>Edit Detail Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-produk" data-base-url="<?= base_url() ?>" action="" method="post" enctype="multipart/form-data">
        <div class="modal-body p-4" style="min-height: 520px;">
          <div class="row">
            <!-- Kolom Kiri: Info Produk -->
            <div class="col-lg-6 pe-lg-4 mb-4 mb-lg-0" style="border-right: 1px solid #f1f5f9;">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-info-circle me-1"></i>Informasi Produk</h6>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="edit-nama">Nama Produk</label>
                <input type="text" class="form-control form-control-sm" id="edit-nama" name="nama" required>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <label class="form-label small fw-bold text-secondary" for="edit-unit">Unit Bisnis</label>
                  <select class="form-select form-select-sm" id="edit-unit" name="unit_bisnis_id" required>
                    <?php foreach ($units as $unit): ?>
                      <option value="<?= esc($unit['id']) ?>"><?= esc($unit['nama']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label small fw-bold text-secondary" for="edit-parent">Parent (Varian Dari)</label>
                  <select class="form-select form-select-sm" id="edit-parent" name="parent_id">
                    <option value="">-- Produk Utama --</option>
                    <?php foreach ($products as $p): ?>
                      <?php if ($p['parent_id'] === null): ?>
                        <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="edit-harga">Harga Jual</label>
                  <input type="number" class="form-control form-control-sm" id="edit-harga" name="harga" required>
                </div>
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="edit-satuan">Satuan</label>
                  <select class="form-select form-select-sm" id="edit-satuan" name="satuan" required>
                    <option value="Sisir">Sisir</option>
                    <option value="Kg">Kg</option>
                    <option value="Ekor">Ekor</option>
                    <option value="Pack">Pack</option>
                  </select>
                </div>
                <div class="col-4">
                  <label class="form-label small fw-bold text-secondary" for="edit-stok">Stok Tersedia</label>
                  <input type="number" class="form-control form-control-sm" id="edit-stok" name="stok" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="edit-singkat">Deskripsi Singkat</label>
                <input type="text" class="form-control form-control-sm" id="edit-singkat" name="deskripsi_singkat" required>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="edit-lengkap">Deskripsi Lengkap</label>
                <textarea class="form-control form-control-sm" id="edit-lengkap" name="deskripsi_lengkap" rows="5" required></textarea>
              </div>
            </div>

            <!-- Kolom Kanan: Foto & Galeri -->
            <div class="col-lg-6 ps-lg-4">
              <h6 class="fw-bold text-primary mb-3" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;"><i class="ti ti-photo me-1"></i>Foto Produk</h6>

              <div class="mb-3">
                <label class="form-label small fw-bold text-secondary" for="edit-foto-produk">Ganti Foto Utama Produk</label>
                <input type="file" class="form-control form-control-sm" id="edit-foto-produk" name="foto_produk" accept="image/*">
                <div class="form-text small mb-2">Kosongkan jika tidak ingin mengganti.</div>
                <div id="edit-foto-preview" style="max-width: 150px; border-radius: 8px; overflow: hidden;"></div>
              </div>

              <div class="mb-0">
                <label class="form-label small fw-bold text-secondary" for="edit-gallery-produk">Kelola Foto Galeri (Multiple)</label>
                <input type="file" class="form-control form-control-sm" id="edit-gallery-produk" name="gallery_produk[]" multiple accept="image/*">
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<?= $this->endSection() ?>
