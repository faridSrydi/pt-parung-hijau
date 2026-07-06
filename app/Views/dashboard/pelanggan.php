<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container" style="padding-top: 140px; padding-bottom: 80px;">
  <section class="dashboard-section">
    <div class="dashboard-grid">

      <!-- Sidebar -->
      <aside class="dashboard-sidebar">
          <div class="user-profile-header">
            <div class="user-avatar-placeholder" id="user-avatar">
              <?= strtoupper(substr(auth()->user()->username ?? 'P', 0, 1)) ?>
            </div>
            <h4 id="user-display-name"><?= esc(auth()->user()->username ?? 'Pengguna') ?></h4>
            <p id="user-display-email"><?= esc(auth()->user()->email ?? 'user@test.com') ?></p>
          </div>

          <ul class="dashboard-menu">
            <li>
              <a href="#" class="dashboard-menu-link active" id="menu-summary" onclick="switchDashboardTab('summary', event)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
                </svg>
                Ringkasan & Pesanan
              </a>
            </li>
            <li>
              <a href="#" class="dashboard-menu-link" id="menu-settings" onclick="switchDashboardTab('settings', event)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.47,5.34 14.86,5.08L14.48,2.42C14.44,2.18 14.24,2 14,2H10C9.76,2 9.56,2.18 9.52,2.42L9.14,5.08C8.53,5.34 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.95C7.96,18.34 8.53,18.66 9.14,18.92L9.52,21.58C9.56,21.82 9.76,22 10,22H14C14.24,22 14.44,21.82 14.48,21.58L14.86,18.92C15.47,18.66 16.04,18.34 16.56,17.95L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" />
                </svg>
                Pengaturan Akun & Alamat
              </a>
            </li>
            <li>
              <a href="<?= base_url('logout') ?>" class="dashboard-menu-link" style="color: #ef4444 !important;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill: #ef4444 !important;">
                  <path d="M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z" />
                </svg>
                Keluar Sesi
              </a>
            </li>
          </ul>
        </aside>

        <!-- Content Area: Summary Tab -->
        <div class="dashboard-content-card" id="dashboard-summary-panel" style="position: relative;">
          <div class="corner-decor corner-tl"></div>
          <div class="corner-decor corner-tr"></div>
          
          <h2 class="section-title" style="margin-bottom: 24px; font-family: var(--font-serif); color: var(--primary);">Halo, <span id="welcome-name"><?= esc(auth()->user()->username ?? 'Pengguna') ?></span>!</h2>
          <p style="color: var(--text-muted); margin-bottom: 30px;">Selamat datang di dashboard akun Anda. Di sini Anda dapat memantau pesanan Anda, mengunggah bukti pembayaran manual, dan melacak riwayat transaksi Anda.</p>

          <!-- Stats Grid -->
          <div class="stats-grid">
            <div class="stat-card">
              <span class="stat-icon"><i class="ti ti-shopping-cart"></i></span>
              <span class="stat-num" id="customer-stat-total-orders"><?= count($transactions) ?></span>
              <span class="stat-lbl">Total Pesanan</span>
            </div>
            <div class="stat-card">
              <span class="stat-icon"><i class="ti ti-clock"></i></span>
              <span class="stat-num" id="customer-stat-pending-payments" style="color: #f59e0b;">
                <?php 
                  $pending = array_filter($transactions, function($t) { return $t['status_pembayaran'] === 'Menunggu Pembayaran'; });
                  echo count($pending);
                ?>
              </span>
              <span class="stat-lbl">Menunggu Pembayaran</span>
            </div>
            <div class="stat-card">
              <span class="stat-icon"><i class="ti ti-check"></i></span>
              <span class="stat-num" id="customer-stat-completed-payments" style="color: #22c55e;">
                <?php 
                  $lunas = array_filter($transactions, function($t) { return $t['status_pembayaran'] === 'Lunas'; });
                  echo count($lunas);
                ?>
              </span>
              <span class="stat-lbl">Lunas</span>
            </div>
          </div>

          <!-- Transaction Table Section -->
          <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 16px;">Riwayat Pesanan Anda</h3>

          <div class="order-table-container">
            <table class="customer-order-table" style="width: 100%; border-collapse: collapse; background: var(--white); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-soft);">
              <thead>
                <tr>
                  <th>ID Pesanan</th>
                  <th>Tanggal</th>
                  <th>Detail Produk</th>
                  <th>Total Harga</th>
                  <th>Metode</th>
                  <th>Status</th>
                  <th style="text-align: center;">Detail</th>
                  <th style="text-align: right;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($transactions)): ?>
                  <?php foreach ($transactions as $tx): ?>
                    <?php 
                      $itemNames = [];
                      foreach ($tx['details'] as $det) {
                          $itemNames[] = esc($det['produk_nama']) . ' (x' . $det['qty'] . ')';
                      }
                      $itemSummary = implode(', ', $itemNames) ?: 'Produk';
                    ?>
                    <tr>
                      <td data-label="ID Pesanan"><strong>#<?= esc($tx['id']) ?></strong></td>
                      <td data-label="Tanggal"><?= date('d M Y', strtotime($tx['tanggal_transaksi'])) ?></td>
                      <td data-label="Detail Produk"><?= esc($itemSummary) ?></td>
                      <td data-label="Total Harga">Rp <?= number_format($tx['total_harga'], 0, ',', '.') ?></td>
                      <td data-label="Metode"><?= esc(ucfirst($tx['metode_pembayaran'])) ?></td>
                      <td data-label="Status">
                        <?php if ($tx['status_pembayaran'] === 'Lunas'): ?>
                          <span class="badge" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">Lunas - <?= esc($tx['logistik_status'] ?? 'Diproses') ?></span>
                        <?php else: ?>
                          <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap;"><?= esc($tx['status_pembayaran']) ?></span>
                        <?php endif; ?>
                      </td>
                      <td data-label="Detail" style="text-align: center;">
                        <?php 
                          $statusHtml = '';
                          if ($tx['status_pembayaran'] === 'Lunas') {
                              $statusHtml = '<span class="badge" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">Lunas - ' . esc($tx['logistik_status'] ?? 'Diproses') . '</span>';
                          } else {
                              $statusHtml = '<span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">' . esc($tx['status_pembayaran']) . '</span>';
                          }
                          
                          $txData = [
                              'id' => $tx['id'],
                              'tanggal' => date('d M Y', strtotime($tx['tanggal_transaksi'])),
                              'statusBadge' => $statusHtml,
                              'alamat' => $tx['shipping_address'] ?: 'Alamat tidak tersedia',
                              'total_harga' => $tx['total_harga'],
                              'details' => $tx['details'] ?? []
                          ];
                        ?>
                        <button class="btn btn-light border" style="padding: 6px 14px; font-size: 0.8rem; border-radius: 20px; min-height: auto; width: auto;" 
                                data-info='<?= esc(json_encode($txData), 'attr') ?>' 
                                onclick="openOrderDetailModal(this)">Detail</button>
                      </td>
                      <td data-label="Aksi" style="text-align: right;">
                        <?php if ($tx['status_pembayaran'] === 'Lunas'): ?>
                          <?php if (($tx['logistik_status'] ?? '') === 'Selesai'): ?>
                            <span class="text-success small" style="font-weight: 600;"><i class="ti ti-check-box"></i> Selesai</span>
                          <?php else: ?>
                            <button class="btn btn-primary" style="padding: 6px 14px; font-size: 0.8rem; border-radius: 20px; opacity: 0.65; cursor: not-allowed; min-height: auto; width: auto;" disabled>Lacak Kurir</button>
                          <?php endif; ?>
                        <?php else: ?>
                          <button class="btn btn-terracotta" style="padding: 6px 14px; font-size: 0.8rem; border-radius: 20px; background: var(--terracotta); border-color: var(--terracotta); color: var(--white); min-height: auto; width: auto;" onclick="openPaymentProofModal('<?= esc($tx['id']) ?>', <?= $tx['total_harga'] ?>)">Kirim Bukti</button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat pesanan.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Content Area: Settings Tab -->
        <div class="dashboard-content-card" id="dashboard-settings-panel" style="display: none; position: relative;">
          <div class="corner-decor corner-tl"></div>
          <div class="corner-decor corner-tr"></div>
          
          <h2 class="section-title" style="margin-bottom: 24px; font-family: var(--font-serif); color: var(--primary);">Pengaturan Akun & Alamat</h2>
          
          <!-- Account Settings Form -->
          <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 16px; border-bottom: 1px solid rgba(182, 138, 88, 0.15); padding-bottom: 8px;">Ubah Profil</h3>
          <form id="dashboard-profile-form" onsubmit="handleUpdateProfile(event)" style="margin-bottom: 40px;">
            <div class="form-group-grid">
              <div>
                <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block;">Nama Lengkap</label>
                <input type="text" id="settings-name" value="<?= esc(auth()->user()->username ?? 'Pengguna') ?>" required class="auth-input" style="width: 100%;">
              </div>
              <div>
                <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block;">Email (Tidak Dapat Diubah)</label>
                <input type="email" id="settings-email" value="<?= esc(auth()->user()->email ?? 'email@domain.com') ?>" disabled class="auth-input" style="width: 100%; opacity: 0.65; cursor: not-allowed;">
              </div>
            </div>
            <div class="form-group-grid">
              <div>
                <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block;">Kata Sandi Baru</label>
                <input type="password" id="settings-password" class="auth-input" style="width: 100%;" placeholder="Kosongkan jika tidak ingin diubah">
              </div>
              <div>
                <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block;">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="settings-password-confirm" class="auth-input" style="width: 100%;" placeholder="Tulis ulang kata sandi baru">
              </div>
            </div>
            <button type="submit" class="btn btn-terracotta" style="padding: 10px 20px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">Simpan Perubahan</button>
          </form>
          
          <!-- Address Management -->
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(182, 138, 88, 0.15); padding-bottom: 8px;">
            <h3 style="font-family: var(--font-serif); color: var(--primary); margin: 0;">Alamat Pengiriman Saya</h3>
            <button class="btn btn-primary" type="button" onclick="openAddAddressForm()" style="padding: 8px 16px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">+ Alamat Baru</button>
          </div>
          
          <!-- Address List Container -->
          <div id="customer-addresses-container" class="address-cards-grid">
            <?php if (!empty($addresses)): ?>
              <?php foreach ($addresses as $addr): ?>
                <div class="address-card <?= $addr['is_default'] ? 'default' : '' ?>" style="position: relative;">
                  <?php if ($addr['is_default']): ?>
                    <span class="badge" style="background: var(--accent); color: var(--white); font-size: 0.7rem; padding: 4px 8px; border-radius: 4px; position: absolute; top: 15px; right: 15px;">Utama (Default)</span>
                  <?php endif; ?>
                  <h4 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 8px; font-size: 1.1rem;"><?= esc($addr['recipient_name']) ?></h4>
                  <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;"><i class="ti ti-mobile"></i> <?= esc($addr['phone']) ?></p>
                  <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px; line-height: 1.5;"><i class="ti ti-location-pin"></i> <?= esc($addr['address_line']) ?></p>
                  <div style="display: flex; gap: 8px; border-top: 1px solid rgba(182, 138, 88, 0.15); padding-top: 12px; margin-top: auto;">
                    <?php 
                        $addrData = [
                            'id' => $addr['id'],
                            'recipient_name' => $addr['recipient_name'],
                            'phone' => $addr['phone'],
                            'address_line' => $addr['address_line'],
                            'is_default' => $addr['is_default']
                        ];
                    ?>
                    <button class="btn btn-light border" style="padding: 4px 12px !important; font-size: 0.75rem !important; border-radius: 15px !important; min-height: auto; width: auto;" onclick="openEditAddressForm(this)" data-info='<?= esc(json_encode($addrData), 'attr') ?>'>Edit</button>
                    <button class="btn btn-light border text-danger" style="padding: 4px 12px !important; font-size: 0.75rem !important; border-radius: 15px !important; min-height: auto; width: auto; color: #ef4444;" onclick="hapusAlamat(<?= $addr['id'] ?>)">Hapus</button>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="address-card" style="grid-column: 1/-1; text-align: center; border: 1px dashed rgba(182, 138, 88, 0.2); padding: 30px;">
                <p class="text-muted mb-0">Belum ada alamat tersimpan. Alamat akan tersimpan otomatis saat Anda pertama kali checkout.</p>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Add New Address Form Wrapper (hidden initially) -->
          <div id="add-address-form-wrapper" style="display: none; background: rgba(182, 138, 88, 0.05); border: 1px dashed var(--accent); border-radius: 20px; padding: 24px; margin-top: 30px; position: relative;">
            <h4 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 16px;" id="address-form-title">Tambah Alamat Baru</h4>
            <form id="dashboard-address-form" onsubmit="submitCustomerAddress(event)">
              <input type="hidden" id="address-id" value="">
              <div class="form-group-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                <div>
                  <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 6px; display: block;">Nama Penerima <span style="color: red;">*</span></label>
                  <input type="text" id="address-recipient-name" required class="auth-input" style="width: 100%;">
                </div>
                <div>
                  <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 6px; display: block;">Nomor Telepon / WhatsApp <span style="color: red;">*</span></label>
                  <input type="tel" id="address-recipient-phone" required class="auth-input" style="width: 100%;">
                </div>
              </div>
              <div class="form-group" style="margin-bottom: 15px;">
                <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 6px; display: block;">Alamat Pengiriman <span style="color: red;">*</span></label>
                <textarea id="address-line" required class="auth-input" style="width: 100%; height: 80px; padding: 12px; resize: none;"></textarea>
              </div>
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                <input type="checkbox" id="address-is-default" style="width: 16px; height: 16px; cursor: pointer;">
                <label for="address-is-default" style="font-size: 0.88rem; color: var(--text-muted); cursor: pointer; user-select: none;">Jadikan alamat pengiriman utama (Default)</label>
              </div>
              <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-primary" onclick="closeAddAddressForm()" style="padding: 10px 20px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">Batal</button>
                <button type="submit" class="btn btn-terracotta" style="padding: 10px 20px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">Simpan Alamat</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </div>

<!-- Upload Payment Proof Modal -->
<div class="upload-modal-overlay" id="upload-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 37, 25, 0.6); align-items: center; justify-content: center; z-index: 99999;">
  <div class="upload-modal-content">
    <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 8px;">Kirim Bukti Pembayaran</h3>
    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.4;">Transfer sebesar <strong id="upload-amount-label">Rp 0</strong> ke rekening berikut:</p>

    <div style="background-color: var(--bg-cream-dark); border: 1px solid rgba(182, 138, 88, 0.2); border-radius: 8px; padding: 12px; margin: 12px 0; font-size: 0.9rem;">
      <div><strong>Bank Mandiri</strong></div>
      <div style="font-size: 1.1rem; letter-spacing: 1px; color: var(--accent); font-weight: 700; margin: 4px 0;">133-00-9876543-2</div>
      <div style="font-size: 0.8rem; color: var(--text-muted);">a.n. PT Parung Hijau Perkasa</div>
    </div>

    <form id="upload-proof-form" onsubmit="handleUploadProofSubmit(event)">
      <input type="hidden" id="upload-order-id">
      <label class="auth-label" style="color: var(--primary); margin-top: 12px; display: block; margin-bottom: 8px;">Unggah Tangkapan Layar (Screenshot) / Foto Resi</label>

      <div class="upload-zone" onclick="triggerFileInput()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: var(--accent); margin-bottom: 8px; margin-left: auto; margin-right: auto; display: block;">
          <path d="M9,16V10H5L12,3L19,10H15V16H9M5,20V18H19V20H5Z" />
        </svg>
        <div style="font-weight: 600; font-size: 0.85rem; color: var(--primary);">Klik untuk memilih berkas gambar</div>
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Mendukung format JPG, PNG (Simulasi upload)</div>

        <input type="file" id="proof-file-input" style="display: none;" accept="image/*" onchange="previewProofImage(event)">
        <img id="proof-preview-img" class="upload-preview" alt="Preview Bukti" style="display: none; max-width: 100%; max-height: 120px; object-fit: contain; margin-top: 12px; border-radius: 6px; border: 1px solid rgba(182, 138, 88, 0.2); margin-left: auto; margin-right: auto;">
      </div>

      <div style="display: flex; gap: 10px; margin-top: 20px; justify-content: flex-end;">
        <button type="button" class="btn btn-primary" onclick="closeUploadModal()" style="padding: 10px 20px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">Batal</button>
        <button type="submit" class="btn btn-terracotta" style="padding: 10px 20px !important; font-size: 0.85rem !important; border-radius: 30px !important; min-height: auto; width: auto;">Kirim Bukti</button>
      </div>
    </form>
  </div>
</div>

<!-- Order Detail Modal -->
<div class="upload-modal-overlay" id="order-detail-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 37, 25, 0.6); align-items: center; justify-content: center; z-index: 99999;">
  <div class="upload-modal-content" style="background: var(--white); border-radius: 20px; padding: 36px; max-width: 600px; width: 90%; border: 1px solid rgba(182, 138, 88, 0.2); box-shadow: var(--shadow-lux); position: relative; max-height: 85vh; overflow-y: auto;">
    <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 16px; border-bottom: 1px solid rgba(182, 138, 88, 0.15); padding-bottom: 10px;" id="detail-modal-title">Detail Pesanan</h3>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; font-size: 0.9rem; color: var(--text-main);">
      <div>
        <span style="color: var(--text-muted); font-size: 0.8rem; display: block;">Tanggal Pembelian</span>
        <strong id="detail-order-date">02 Jul 2026</strong>
      </div>
      <div>
        <span style="color: var(--text-muted); font-size: 0.8rem; display: block;">Metode Pembayaran</span>
        <strong>Transfer Bank Mandiri</strong>
      </div>
      <div>
        <span style="color: var(--text-muted); font-size: 0.8rem; display: block;">Status Transaksi</span>
        <span id="detail-order-status-badge">Paid</span>
      </div>
      <div>
        <span style="color: var(--text-muted); font-size: 0.8rem; display: block;">Alamat Pengiriman</span>
        <strong id="detail-order-address" style="font-weight: 500;">Jl. Raya Puncak No. 123, Cisarua, Bogor</strong>
      </div>
    </div>

    <h4 style="font-family: var(--font-serif); color: var(--primary); font-size: 1.1rem; margin-bottom: 12px; border-top: 1px dashed rgba(182, 138, 88, 0.2); padding-top: 15px;">Daftar Produk</h4>
    
    <div id="detail-products-list" style="display: flex; flex-direction: column; gap: 12px;">
      <!-- Injected by JS -->
    </div>

    <div style="margin-top: 20px; border-top: 1px solid rgba(182, 138, 88, 0.15); padding-top: 15px; font-size: 0.95rem;">
      <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
        <span class="text-muted">Subtotal Produk</span>
        <strong id="detail-summary-subtotal">Rp 170.000</strong>
      </div>
      <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
        <span class="text-muted">Biaya Pengiriman</span>
        <strong style="color: #22c55e;">Gratis Ongkir</strong>
      </div>
      <div style="display: flex; justify-content: space-between; font-size: 1.1rem; border-top: 1px dashed rgba(182, 138, 88, 0.2); padding-top: 8px;">
        <strong style="color: var(--primary);">Total Pembayaran</strong>
        <strong style="color: var(--accent);" id="detail-summary-total">Rp 170.000</strong>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
      <button type="button" class="btn btn-primary" onclick="closeOrderDetailModal()" style="padding: 10px 24px; font-size: 0.85rem; border-radius: 30px; background: var(--primary); border: 1px solid var(--primary); color: var(--white); cursor: pointer;">Tutup</button>
    </div>
  </div>
</div>

<!-- Custom Confirm Delete Modal -->
<div id="custom-delete-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 9999; justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s ease;">
  <div style="background: var(--white); padding: 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); width: 90%; max-width: 400px; transform: scale(0.9); transition: transform 0.3s ease;" id="custom-delete-modal-box">
    <div style="text-align: center; margin-bottom: 20px;">
      <div style="width: 60px; height: 60px; background: rgba(239, 68, 68, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
        <i class="ti ti-trash" style="font-size: 28px; color: #ef4444;"></i>
      </div>
      <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 10px;">Hapus Alamat?</h3>
      <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0; line-height: 1.5;">Apakah Anda yakin ingin menghapus alamat ini? Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <div style="display: flex; gap: 10px; justify-content: center;">
      <button class="btn btn-light" onclick="closeCustomDeleteModal()" style="border-radius: 30px; padding: 10px 24px; font-weight: 600; flex: 1;">Batal</button>
      <button class="btn btn-primary" id="confirm-delete-btn" style="background: #ef4444; border-color: #ef4444; border-radius: 30px; padding: 10px 24px; font-weight: 600; flex: 1;">Ya, Hapus</button>
    </div>
  </div>
</div>



<?= $this->endSection() ?>
