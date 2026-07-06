<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Header -->
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Kelola Supir & Armada</h1>
      <p class="text-muted small">Kelola daftar supir operasional dan armada kendaraan pengiriman milik PT Parung Hijau Perkasa.</p>
    </div>
  </div>
</div>

<!-- Main Table Card -->
<div class="row">
  <div class="col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      
      <!-- Top Action Bar -->
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-users text-primary me-2"></i>Daftar Supir Aktif</h5>
        <button class="btn btn-sm btn-primary px-3 py-2 small" data-bs-toggle="modal" data-bs-target="#modalTambahSupir">
          <i class="ti ti-plus me-1"></i> Tambah Supir / Armada
        </button>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
              <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Nama Supir</th>
              <th style="font-weight: 600; color: #64748b;">No Handphone</th>
              <th style="font-weight: 600; color: #64748b;">Armada Kendaraan</th>
              <th style="font-weight: 600; color: #64748b;">Nomor Plat</th>
              <th style="font-weight: 600; color: #64748b;">Status</th>
              <th class="text-end pe-3" style="font-weight: 600; color: #64748b;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($drivers)): ?>
              <?php foreach ($drivers as $driver): ?>
                <?php 
                  $parts = explode(' (', $driver['nomor_kendaraan']);
                  $plat = $parts[0];
                  $armada = isset($parts[1]) ? rtrim($parts[1], ')') : 'Mobil Boks';
                ?>
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td class="ps-3">
                    <div class="d-flex align-items-center gap-2">
                      <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 36px; height: 36px; font-weight: 600;"><?= strtoupper(substr($driver['nama'], 4, 1) ?: 'S') ?></div>
                      <strong><?= esc($driver['nama']) ?></strong>
                    </div>
                  </td>
                  <td><?= esc($driver['telepon']) ?></td>
                  <td><?= esc($armada) ?></td>
                  <td><strong><?= esc($plat) ?></strong></td>
                  <td><span class="badge bg-success py-1 px-2"><?= esc($driver['status']) ?></span></td>
                  <td class="text-end pe-3">
                    <button class="btn btn-sm btn-light border py-1 px-2 text-secondary btn-edit-supir" 
                      data-id="<?= $driver['id'] ?>" data-nama="<?= esc($driver['nama']) ?>" data-phone="<?= esc($driver['telepon']) ?>" data-armada="<?= esc($armada) ?>" data-plat="<?= esc($plat) ?>"><i class="ti ti-pencil"></i> Edit</button>
                    <button class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="window.confirmDelete('<?= base_url('admin/supir/hapus/' . $driver['id']) ?>', 'Apakah Anda yakin ingin menghapus data supir <?= esc($driver['nama']) ?> dari sistem?')"><i class="ti ti-trash"></i> Hapus</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada supir terdaftar.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Modal Tambah Supir -->
<div class="modal fade" id="modalTambahSupir" tabindex="-1" aria-labelledby="modalTambahSupirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalTambahSupirLabel"><i class="ti ti-plus text-primary me-2"></i>Registrasi Supir & Armada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('admin/supir/tambah') ?>" method="post">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="add-nama">Nama Lengkap Supir</label>
            <input type="text" class="form-control" id="add-nama" name="nama" placeholder="e.g. Pak Jono" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="add-phone">Nomor Handphone (Aktif)</label>
            <input type="tel" class="form-control" id="add-phone" name="telepon" placeholder="e.g. 0812xxxxxxxx" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="row g-3 mb-0">
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="add-armada">Jenis Armada</label>
              <select class="form-select form-control" id="add-armada" name="armada" style="height: 44px; border-radius: 6px;" required>
                <option value="Avanza Boks">Avanza Boks</option>
                <option value="Pick Up L300">Pick Up L300</option>
                <option value="Blind Van">Blind Van</option>
                <option value="Truk Engkel">Truk Engkel</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="add-plat">Nomor Plat Polisi</label>
              <input type="text" class="form-control" id="add-plat" name="plat" placeholder="e.g. B 1234 XY" style="height: 44px; border-radius: 6px;" required>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light p-3">
          <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px;">Daftarkan Supir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Supir -->
<div class="modal fade" id="modalEditSupir" tabindex="-1" aria-labelledby="modalEditSupirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalEditSupirLabel"><i class="ti ti-pencil text-primary me-2"></i>Edit Data Supir & Armada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-supir" data-base-url="<?= base_url() ?>" action="" method="post">
        <div class="modal-body p-4">
          <input type="hidden" id="edit-id">
          
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-nama">Nama Lengkap Supir</label>
            <input type="text" class="form-control" id="edit-nama" name="nama" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-phone">Nomor Handphone (Aktif)</label>
            <input type="tel" class="form-control" id="edit-phone" name="telepon" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="row g-3 mb-0">
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-armada">Jenis Armada</label>
              <select class="form-select form-control" id="edit-armada" name="armada" style="height: 44px; border-radius: 6px;" required>
                <option value="Avanza Boks">Avanza Boks</option>
                <option value="Pick Up L300">Pick Up L300</option>
                <option value="Blind Van">Blind Van</option>
                <option value="Truk Engkel">Truk Engkel</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-plat">Nomor Plat Polisi</label>
              <input type="text" class="form-control" id="edit-plat" name="plat" style="height: 44px; border-radius: 6px;" required>
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
