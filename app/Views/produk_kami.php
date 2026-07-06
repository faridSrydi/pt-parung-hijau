<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container" style="padding-top: 100px;">
  <section class="section" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
      <div class="section-header center reveal reveal-slide-up">
        <span class="designer-badge">Katalog Penjualan</span>
        <h2>Produk Unggulan <span>Kami</span></h2>
        <p>Temukan produk pangan segar berkualitas tinggi dan solusi berkelanjutan yang kami hasilkan langsung dari setiap unit bisnis.</p>
      </div>

      <!-- Category Filter Tabs -->
      <div class="filter-tabs reveal reveal-slide-up delay-1">
        <button class="filter-btn active" data-filter="semua">Semua Produk</button>
        <?php if (!empty($units)): ?>
          <?php foreach ($units as $unit): ?>
            <button class="filter-btn" data-filter="<?= esc($unit['id']) ?>"><?= esc($unit['nama']) ?></button>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Products Grid -->
      <div class="grid-4" id="products-catalog-grid">
        <!-- Populated dynamically by JS -->
      </div>
    </div>
  </section>
</div>

<!-- ==========================================================================
     QUICK-VIEW DETAILS MODAL (Product Drawer)
     ========================================================================== -->
<div class="modal-overlay" id="product-modal">
  <div class="modal-content">
    <button class="modal-close-btn" id="modal-close" aria-label="Tutup Detail">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;">
        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
      </svg>
    </button>
    <div class="modal-grid" id="modal-grid-content">
      <!-- Injected dynamically by app.js -->
    </div>
  </div>
</div>
<?= $this->endSection() ?>
