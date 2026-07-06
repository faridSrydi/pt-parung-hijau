<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title) ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #333;
      margin: 30px;
      line-height: 1.4;
      font-size: 13px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
      margin-bottom: 30px;
    }
    .header h2 {
      margin: 0;
      font-size: 20px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #111;
    }
    .header p {
      margin: 5px 0 0;
      color: #666;
      font-size: 12px;
    }
    .meta-table {
      width: 100%;
      margin-bottom: 20px;
      font-size: 12px;
    }
    .meta-table td {
      padding: 4px 0;
      vertical-align: top;
    }
    .meta-title {
      font-weight: bold;
      width: 120px;
    }
    .report-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .report-table th, .report-table td {
      border: 1px solid #ddd;
      padding: 10px 8px;
      text-align: left;
    }
    .report-table th {
      background-color: #f7f9fa;
      font-weight: bold;
      color: #333;
    }
    .report-table tr:nth-child(even) {
      background-color: #fafbfc;
    }
    .text-end {
      text-align: right;
    }
    .text-center {
      text-align: center;
    }
    .total-row {
      font-weight: bold;
      background-color: #f1f3f5 !important;
    }
    .footer-sign {
      margin-top: 50px;
      float: right;
      width: 200px;
      text-align: center;
    }
    .footer-sign-space {
      height: 70px;
    }
    .badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 11px;
      font-weight: 600;
    }
    .bg-success { background-color: #d1e7dd; color: #0f5132; }
    .bg-warning { background-color: #fff3cd; color: #664d03; }
    .bg-info { background-color: #cff4fc; color: #087990; }
    .bg-danger { background-color: #f8d7da; color: #842029; }
    
    @media print {
      body {
        margin: 20px;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <h2>PT Parung Hijau Perkasa</h2>
    <p>Jl. Raya Parung No. 123, Kabupaten Bogor, Jawa Barat</p>
    <p>Telp: (0251) 87654321 | Email: info@parunghijau.com</p>
  </div>

  <h3 style="text-align: center; margin-top: 0; margin-bottom: 20px; text-transform: uppercase;"><?= esc($title) ?></h3>

  <!-- Meta Info -->
  <table class="meta-table">
    <tr>
      <td class="meta-title">Laporan</td>
      <td>: <?= esc($title) ?></td>
      <td class="meta-title" style="text-align: right;">Tanggal Cetak</td>
      <td style="text-align: right;">: <?= date('d M Y H:i') ?></td>
    </tr>
    <tr>
      <?php if ($jenis !== 'stok'): ?>
        <td class="meta-title">Periode</td>
        <td>: <?= date('d M Y', strtotime($mulai)) ?> s/d <?= date('d M Y', strtotime($selesai)) ?></td>
      <?php else: ?>
        <td class="meta-title">Status</td>
        <td>: Aktif (Stok Terkini)</td>
      <?php endif; ?>
      <td class="meta-title" style="text-align: right;">Dicetak Oleh</td>
      <td style="text-align: right;">: Admin PHP</td>
    </tr>
  </table>

  <!-- Report Data Table -->
  <table class="report-table">
    <?php if ($jenis === 'penjualan'): ?>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Penerima</th>
          <th>Alamat</th>
          <th>Metode Bayar</th>
          <th class="text-end">Total Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $totalSales = 0;
          if (!empty($data)): 
            foreach ($data as $row): 
              $totalSales += $row['total_harga'];
        ?>
          <tr>
            <td><strong>#<?= esc($row['id']) ?></strong></td>
            <td><?= date('d M Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
            <td><?= esc($row['pelanggan_nama'] ?? 'Pelanggan') ?></td>
            <td><?= esc($row['recipient_name']) ?></td>
            <td><?= esc($row['shipping_address']) ?></td>
            <td class="text-capitalize"><?= esc($row['metode_pembayaran']) ?></td>
            <td class="text-end">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
          </tr>
        <?php 
            endforeach; 
          else:
        ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Tidak ada data penjualan pada periode ini.</td>
          </tr>
        <?php endif; ?>
        <tr class="total-row">
          <td colspan="6" class="text-end">Total Pendapatan (Omset):</td>
          <td class="text-end">Rp <?= number_format($totalSales, 0, ',', '.') ?></td>
        </tr>
      </tbody>

    <?php elseif ($jenis === 'produksi'): ?>
      <thead>
        <tr>
          <th>ID Panen</th>
          <th>Tanggal Panen</th>
          <th>Komoditas/Produk</th>
          <th>Petugas/Petani</th>
          <th>Kualitas</th>
          <th class="text-end">Volume</th>
          <th>Satuan</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $totalVol = 0;
          if (!empty($data)): 
            foreach ($data as $row): 
              $totalVol += $row['volume'];
        ?>
          <tr>
            <td><strong>#PAN-<?= esc($row['id']) ?></strong></td>
            <td><?= date('d M Y', strtotime($row['tanggal_panen'])) ?></td>
            <td><?= esc($row['produk_nama']) ?></td>
            <td><?= esc($row['petugas_nama']) ?></td>
            <td class="text-capitalize"><?= str_replace('_', ' ', esc($row['kualitas'])) ?></td>
            <td class="text-end"><?= number_format($row['volume'], 0, ',', '.') ?></td>
            <td><?= esc($row['satuan']) ?></td>
          </tr>
        <?php 
            endforeach; 
          else:
        ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Tidak ada data hasil panen pada periode ini.</td>
          </tr>
        <?php endif; ?>
        <tr class="total-row">
          <td colspan="5" class="text-end">Total Volume Hasil Panen:</td>
          <td class="text-end"><?= number_format($totalVol, 0, ',', '.') ?></td>
          <td>Unit</td>
        </tr>
      </tbody>

    <?php elseif ($jenis === 'distribusi'): ?>
      <thead>
        <tr>
          <th>ID Kirim</th>
          <th>Order ID</th>
          <th>Metode</th>
          <th>Kurir / Armada / Resi</th>
          <th>Penerima</th>
          <th>Alamat Tujuan</th>
          <th class="text-center">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          if (!empty($data)): 
            foreach ($data as $row): 
              $isManual = $row['metode_pengiriman'] === 'manual';
              $kurir = $isManual 
                  ? 'Kurir Parung (' . esc($row['supir_nama'] ?? '-') . ' - ' . esc($row['nomor_kendaraan'] ?? '-') . ')' 
                  : esc($row['ekspedisi_nama']) . ' (Resi: ' . esc($row['nomor_resi'] ?: 'Belum di-input') . ')';
        ?>
          <tr>
            <td><strong>#DEL-<?= esc($row['id']) ?></strong></td>
            <td><strong>#<?= esc($row['transaksi_id']) ?></strong></td>
            <td class="text-capitalize"><?= esc($row['metode_pengiriman']) ?></td>
            <td><?= esc($kurir) ?></td>
            <td><?= esc($row['recipient_name']) ?></td>
            <td><?= esc($row['shipping_address']) ?></td>
            <td class="text-center">
              <span class="badge bg-info"><?= esc($row['status_pengiriman']) ?></span>
            </td>
          </tr>
        <?php 
            endforeach; 
          else:
        ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Tidak ada data distribusi pada periode ini.</td>
          </tr>
        <?php endif; ?>
      </tbody>

    <?php elseif ($jenis === 'stok'): ?>
      <thead>
        <tr>
          <th>ID Produk</th>
          <th>Nama Produk</th>
          <th>Unit Bisnis</th>
          <th class="text-end">Harga Satuan</th>
          <th>Satuan</th>
          <th class="text-end">Stok Tersedia</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          if (!empty($data)): 
            foreach ($data as $row): 
              $lowStock = $row['stok'] <= 10;
        ?>
          <tr>
            <td><strong>#<?= esc($row['id']) ?></strong></td>
            <td><?= esc($row['nama']) ?></td>
            <td class="text-capitalize"><?= esc($row['unit_nama']) ?></td>
            <td class="text-end">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= esc($row['satuan']) ?></td>
            <td class="text-end <?= $lowStock ? 'text-danger fw-bold' : '' ?>">
              <?= esc($row['stok']) ?>
              <?php if ($lowStock): ?>
                <span style="font-size: 10px; color: red;">(Menipis)</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php 
            endforeach; 
          else:
        ?>
          <tr>
            <td colspan="6" class="text-center text-muted">Tidak ada data produk terdaftar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    <?php endif; ?>
  </table>

  <!-- Signature Block -->
  <div class="footer-sign">
    <p>Bogor, <?= date('d M Y') ?></p>
    <p>Direktur Operasional,</p>
    <div class="footer-sign-space"></div>
    <hr style="border: 0; border-top: 1px solid #333; margin: 0;">
    <p style="font-weight: bold; margin-top: 5px;">H. Ahmad Ridwan, M.M.</p>
  </div>

  <script>
    window.onload = function() {
      window.print();
    }
  </script>
</body>
</html>
