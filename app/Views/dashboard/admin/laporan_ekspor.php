<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="mb-4">
      <h1 class="fs-3 mb-1 font-weight-bold" style="font-weight: 700; color: #1e293b;">Laporan & Ekspor Data</h1>
      <p class="text-muted small">Rekapitulasi penjualan, total produksi, dan laporan distribusi barang.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Summary Cards -->
  <div class="col-lg-6 col-12">
    <div class="card border-0 p-4 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-4"><i class="ti ti-download text-primary me-2"></i>Ekspor Dokumen Laporan</h5>
      <p class="text-muted small mb-4">Pilih jenis data dan rentang waktu laporan yang ingin diunduh.</p>
      
      <form action="<?= base_url('admin/laporan/ekspor') ?>" method="get" target="_blank">
        <input type="hidden" name="format" id="export-format" value="pdf">
        
        <!-- Jenis Laporan -->
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary" for="jenis-laporan-select">Jenis Laporan</label>
          <select id="jenis-laporan-select" name="jenis_laporan" class="form-select form-control" style="height: 44px; border-radius: 6px;" required>
            <option value="penjualan">Laporan Penjualan (Omset)</option>
            <option value="produksi">Laporan Hasil Panen (Produksi)</option>
            <option value="distribusi">Laporan Pengiriman (Logistik)</option>
            <option value="stok">Laporan Stok Inventaris</option>
          </select>
        </div>

        <!-- Rentang Waktu -->
        <div class="row g-3 mb-4">
          <div class="col-6">
            <label class="form-label small fw-bold text-secondary" for="tanggal-mulai-input">Tanggal Mulai</label>
            <input type="date" id="tanggal-mulai-input" name="tanggal_mulai" class="form-control" value="<?= date('Y-m-01') ?>" style="height: 44px; border-radius: 6px;" required>
          </div>
          <div class="col-6">
            <label class="form-label small fw-bold text-secondary" for="tanggal-selesai-input">Tanggal Selesai</label>
            <input type="date" id="tanggal-selesai-input" name="tanggal_selesai" class="form-control" value="<?= date('Y-m-d') ?>" style="height: 44px; border-radius: 6px;" required>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-6">
            <button type="submit" onclick="document.getElementById('export-format').value='pdf'" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 6px;"><i class="ti ti-file-text me-1"></i> PDF</button>
          </div>
          <div class="col-6">
            <button type="submit" onclick="document.getElementById('export-format').value='excel'" class="btn btn-outline-primary w-100 py-2 fw-bold" style="border-radius: 6px;"><i class="ti ti-table me-1"></i> Excel</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Summary Stats -->
  <div class="col-lg-6 col-12">
    <div class="card border-0 p-4 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-4"><i class="ti ti-chart-bar text-primary me-2"></i>Live Monitoring Ringkasan</h5>
      
      <div class="d-flex flex-column gap-3">
        <!-- Transaksi -->
        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center" style="border-radius: 8px;">
          <div>
            <span class="small fw-bold text-secondary d-block" style="font-size: 0.8rem;">Laporan Transaksi (Penjualan)</span>
            <h4 class="mb-0 fw-bold mt-1" style="color: #0c8a5f; font-weight: 700; font-size: 1.3rem;">Rp <?= number_format($totalSales, 0, ',', '.') ?></h4>
          </div>
          <span class="badge bg-success px-3 py-2" style="border-radius: 30px; font-weight: 600;"><?= esc($totalOrders) ?> Lunas</span>
        </div>

        <!-- Produksi -->
        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center" style="border-radius: 8px;">
          <div>
            <span class="small fw-bold text-secondary d-block" style="font-size: 0.8rem;">Laporan Produksi (Hasil Panen)</span>
            <h4 class="mb-0 fw-bold mt-1" style="color: #0284c7; font-weight: 700; font-size: 1.3rem;"><?= number_format($totalHarvest, 0, ',', '.') ?> Unit</h4>
          </div>
          <span class="badge bg-primary px-3 py-2" style="border-radius: 30px; font-weight: 600;"><?= esc($totalTani) ?> Unit Bisnis</span>
        </div>

        <!-- Distribusi -->
        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center" style="border-radius: 8px;">
          <div>
            <span class="small fw-bold text-secondary d-block" style="font-size: 0.8rem;">Laporan Pengiriman (Logistik)</span>
            <h4 class="mb-0 fw-bold mt-1" style="color: #e06e4b; font-weight: 700; font-size: 1.3rem;"><?= esc($totalShipments) ?> Sukses</h4>
          </div>
          <span class="badge bg-warning px-3 py-2" style="border-radius: 30px; font-weight: 600;"><?= esc($activeShipments) ?> Jalan</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================================================
     CHARTS SECTION (Monitoring Visual Laporan with Filter)
     ========================================================================== -->
<div class="row align-items-center mt-5 mb-2">
  <div class="col-md-8 col-12">
    <h3 class="fw-bold text-dark mb-1" style="font-size: 1.4rem;"><i class="ti ti-chart-line text-primary me-2"></i>Visualisasi Monitoring Laporan</h3>
    <p class="text-muted small mb-0">Representasi visual interaktif dari performa bisnis dan hasil bumi PT Parung Hijau Perkasa.</p>
  </div>
  <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
    <div class="d-inline-flex align-items-center gap-2">
      <label class="small fw-bold text-secondary mb-0" for="chart-time-filter">Skala Waktu:</label>
      <select id="chart-time-filter" class="form-select form-control-sm" style="width: 170px; height: 38px; border-radius: 6px; border: 1px solid rgba(12, 138, 95, 0.3); font-size: 0.85rem;" onchange="updateChartsTimeframe(this.value)">
        <option value="today">Hari Ini</option>
        <option value="6months" selected>6 Bulan Terakhir</option>
        <option value="30days">30 Hari Terakhir</option>
        <option value="1year">1 Tahun Terakhir</option>
      </select>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Grafik Batang: Penjualan -->
  <div class="col-lg-7 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-4"><i class="ti ti-activity text-primary me-2"></i>Tren Omset Penjualan Bulanan (IDR)</h5>
      <div style="height: 300px; position: relative;">
        <canvas id="salesBarChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Grafik Bulat: Proporsi Bisnis -->
  <div class="col-lg-5 col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-4"><i class="ti ti-pie-chart text-primary me-2"></i>Kontribusi Lini Bisnis (%)</h5>
      <div style="height: 300px; position: relative; display: flex; align-items: center; justify-content: center;">
        <canvas id="businessPieChart" style="max-height: 255px; max-width: 255px;"></canvas>
      </div>
    </div>
  </div>

  <!-- Grafik Garis: Volume Hasil Panen -->
  <div class="col-12">
    <div class="card border-0 p-4 shadow-sm" style="border-radius: 12px; background: #ffffff;">
      <h5 class="fw-bold text-dark mb-4"><i class="ti ti-trending-up text-primary me-2"></i>Tren Volume Produksi Panen Komoditas</h5>
      <div style="height: 320px; position: relative;">
        <canvas id="harvestLineChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Load Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data sets for different timeframes
const dataStore = {
  'today': {
    labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
    sales: <?= $salesDataToday ?>,
    pie: <?= $pieDataToday ?>,
    harvest: <?= $harvestDataToday ?>
  },
  '6months': {
    labels: <?= $chartLabels ?>,
    sales: <?= $salesData ?>,
    pie: <?= $pieData ?>,
    harvest: <?= $harvestData ?>
  },
  '30days': {
    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
    sales: <?= $salesData30 ?>,
    pie: <?= $pieData30 ?>,
    harvest: <?= $harvestData30 ?>
  },
  '1year': {
    labels: ['Kuartal 1', 'Kuartal 2', 'Kuartal 3', 'Kuartal 4'],
    sales: <?= $salesData1Y ?>,
    pie: <?= $pieData1Y ?>,
    harvest: <?= $harvestData1Y ?>
  }
};

const unitBisnisList = <?= $unitBisnisList ?>;
const colors = ['#0c8a5f', '#e06e4b', '#ffc107', '#64748b', '#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981'];

window.updateChartsTimeframe = function(timeframe) {
  const data = dataStore[timeframe];
  if (!data) return;

  // Update Sales Bar Chart
  if (window.salesBarChartInst) {
    window.salesBarChartInst.data.labels = data.labels;
    unitBisnisList.forEach((ub, idx) => {
      if (window.salesBarChartInst.data.datasets[idx]) {
        window.salesBarChartInst.data.datasets[idx].data = data.sales[ub.id] || [];
      }
    });
    window.salesBarChartInst.update();
  }

  // Update Pie Chart
  if (window.businessPieChartInst) {
    window.businessPieChartInst.data.datasets[0].data = data.pie;
    window.businessPieChartInst.update();
  }

  // Update Harvest Line Chart
  if (window.harvestLineChartInst) {
    window.harvestLineChartInst.data.labels = data.labels;
    unitBisnisList.forEach((ub, idx) => {
      if (window.harvestLineChartInst.data.datasets[idx]) {
        window.harvestLineChartInst.data.datasets[idx].data = data.harvest[ub.id] || [];
      }
    });
    window.harvestLineChartInst.update();
  }
};

document.addEventListener('DOMContentLoaded', function() {
  // 1. Sales Bar Chart (Tren Omset Penjualan)
  const barCtx = document.getElementById('salesBarChart').getContext('2d');
  
  const salesDatasets = unitBisnisList.map((ub, idx) => {
    return {
      label: ub.nama,
      data: dataStore['6months'].sales[ub.id] || [],
      backgroundColor: colors[idx % colors.length],
      borderRadius: 4
    };
  });

  window.salesBarChartInst = new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: dataStore['6months'].labels,
      datasets: salesDatasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      },
      scales: {
        y: {
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });

  // 2. Business Pie Chart (Kontribusi Lini Bisnis)
  const pieCtx = document.getElementById('businessPieChart').getContext('2d');
  window.businessPieChartInst = new Chart(pieCtx, {
    type: 'doughnut',
    data: {
      labels: unitBisnisList.map(ub => ub.nama),
      datasets: [{
        data: dataStore['6months'].pie,
        backgroundColor: unitBisnisList.map((ub, idx) => colors[idx % colors.length]),
        borderWidth: 2,
        borderColor: '#ffffff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      },
      cutout: '65%'
    }
  });

  // 3. Harvest Line Chart (Volume Hasil Produksi Panen)
  const lineCtx = document.getElementById('harvestLineChart').getContext('2d');
  
  const harvestDatasets = unitBisnisList.map((ub, idx) => {
    return {
      label: ub.nama,
      data: dataStore['6months'].harvest[ub.id] || [],
      borderColor: colors[idx % colors.length],
      backgroundColor: colors[idx % colors.length] + '1a',
      tension: 0.3,
      fill: true
    };
  });

  window.harvestLineChartInst = new Chart(lineCtx, {
    type: 'line',
    data: {
      labels: dataStore['6months'].labels,
      datasets: harvestDatasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      },
      scales: {
        y: {
          title: {
            display: true,
            text: 'Volume Hasil Panen'
          }
        }
      }
    }
  });
});
</script>
<?= $this->endSection() ?>
