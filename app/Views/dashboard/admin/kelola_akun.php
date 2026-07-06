<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Kelola Akun Pengguna</h1>
      <p class="text-muted small">Manajemen seluruh akun pengguna terdaftar sistem Smart Farming PT Parung Hijau Perkasa.</p>
    </div>
  </div>
</div>

<div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <h5 class="fw-bold text-dark mb-0"><i class="ti ti-users me-2 text-primary"></i>Daftar Pengguna Terdaftar</h5>
    <button class="btn btn-sm btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
      <i class="ti ti-plus me-1"></i> Tambah Akun
    </button>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
          <th class="ps-3" style="font-weight: 600; color: #64748b; padding: 12px 8px;">Nama Lengkap</th>
          <th style="font-weight: 600; color: #64748b;">Alamat Email</th>
          <th style="font-weight: 600; color: #64748b;">Hak Akses (Role)</th>
          <th style="font-weight: 600; color: #64748b;">Status</th>
          <th class="text-end pe-3" style="font-weight: 600; color: #64748b;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $u): ?>
            <tr style="border-bottom: 1px solid #f8fafc;">
              <td class="ps-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 36px; height: 36px; font-weight: 600;"><?= strtoupper(substr($u['username'], 0, 2)) ?></div>
                  <strong><?= esc($u['username']) ?></strong>
                </div>
              </td>
              <td><?= esc($u['email']) ?></td>
              <td>
                <?php 
                  $roleClass = 'bg-primary';
                  if ($u['role'] === 'admin') { $roleClass = 'bg-danger'; }
                  elseif ($u['role'] === 'produksi') { $roleClass = 'bg-success'; }
                  elseif ($u['role'] === 'distribusi') { $roleClass = 'bg-info'; }
                ?>
                <span class="badge <?= $roleClass ?> rounded-pill px-3 py-1"><?= esc(ucfirst($u['role'])) ?></span>
              </td>
              <td><span class="badge bg-success rounded-pill px-3 py-1">Aktif</span></td>
              <td class="text-end pe-3">
                <button class="btn btn-sm btn-light border py-1 px-2 text-secondary btn-edit-akun" 
                  data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['username']) ?>" data-email="<?= esc($u['email']) ?>" data-role="<?= esc($u['role']) ?>" data-status="aktif"><i class="ti ti-pencil"></i> Edit</button>
                <button class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="window.confirmDelete('<?= base_url('admin/akun/hapus/' . $u['id']) ?>', 'Apakah Anda yakin ingin menghapus akun <?= esc($u['username']) ?> dari sistem?')"><i class="ti ti-trash"></i> Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Belum ada akun pengguna terdaftar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Akun -->
<div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-labelledby="modalTambahAkunLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalTambahAkunLabel"><i class="ti ti-user-plus text-primary me-2"></i>Tambah Akun Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('admin/akun/tambah') ?>" method="post">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="add-nama">Nama Lengkap / Username</label>
            <input type="text" class="form-control" id="add-nama" name="username" placeholder="Username" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="add-email">Alamat Email</label>
            <input type="email" class="form-control" id="add-email" name="email" placeholder="email@contoh.com" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="add-password">Kata Sandi (Password)</label>
            <input type="password" class="form-control" id="add-password" name="password" placeholder="Minimal 8 karakter" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="add-role">Hak Akses (Role)</label>
              <select class="form-select form-control" id="add-role" name="role" style="height: 44px; border-radius: 6px;" required>
                <option value="admin">Admin</option>
                <option value="produksi">Petugas Produksi</option>
                <option value="distribusi">Petugas Distribusi</option>
                <option value="pelanggan">Pelanggan</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="add-status">Status Akun</label>
              <select class="form-select form-control" id="add-status" name="status" style="height: 44px; border-radius: 6px;" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light p-3">
          <button type="button" class="btn btn-light border" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px;">Simpan Akun</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Akun -->
<div class="modal fade" id="modalEditAkun" tabindex="-1" aria-labelledby="modalEditAkunLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold" id="modalEditAkunLabel"><i class="ti ti-pencil text-primary me-2"></i>Edit Akun Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-akun" data-base-url="<?= base_url() ?>" action="" method="post">
        <div class="modal-body p-4">
          <input type="hidden" id="edit-id">
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-nama">Nama Lengkap / Username</label>
            <input type="text" class="form-control" id="edit-nama" name="username" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-email">Alamat Email</label>
            <input type="email" class="form-control" id="edit-email" name="email" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary" for="edit-password">Kata Sandi (Password)</label>
            <input type="password" class="form-control" id="edit-password" name="password" placeholder="Kosongkan jika tidak ingin diubah" style="height: 44px; border-radius: 6px;">
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-role">Hak Akses (Role)</label>
              <select class="form-select form-control" id="edit-role" name="role" style="height: 44px; border-radius: 6px;" required>
                <option value="admin">Admin</option>
                <option value="produksi">Petugas Produksi</option>
                <option value="distribusi">Petugas Distribusi</option>
                <option value="pelanggan">Pelanggan</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-secondary" for="edit-status">Status Akun</label>
              <select class="form-select form-control" id="edit-status" name="status" style="height: 44px; border-radius: 6px;" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
              </select>
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
