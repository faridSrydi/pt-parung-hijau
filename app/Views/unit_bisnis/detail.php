<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container">

  <!-- Hero Banner -->
  <section class="section section-primary"
    style="padding: 100px 0; text-align: center; border-radius: 30px; margin: 0 20px 80px 20px;">
    <div class="container">
      <span class="designer-badge"
        style="background: rgba(255,255,255,0.08); color: var(--accent-light); border-color: rgba(255,255,255,0.2);">Unit
        Bisnis</span>
      <h1 style="color: var(--white); font-size: 3.8rem; font-weight: 500; margin-top: 15px;"><?= esc($unit['nama']) ?><br><span class="handwritten"
          style="color: var(--accent-light); font-size: 3.2rem; transform: rotate(-3deg); margin-top: 10px; display: block;"><?= esc($unit['tagline']) ?></span></h1>
    </div>
  </section>

  <!-- Profil Unit Bisnis -->
  <section class="section" style="padding-top: 20px;">
    <div class="container" style="max-width: 960px;">
      <div class="hero-image-wrapper" style="margin-bottom: 50px; padding: 0;">
        <div class="designer-arch-frame" style="padding: 10px;">
          <div style="border: 1px solid var(--accent); border-radius: 30px; padding: 8px;">
            <div
              style="border: 2px solid rgba(15, 37, 25, 0.15); border-radius: 22px; overflow: hidden; height: 450px; width: 100%;">
              <img src="<?= base_url(esc($unit['foto_sampul'] ?? 'assets/images/produk/ayam.jpg')) ?>" alt="<?= esc($unit['nama']) ?>"
                style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>
          </div>
        </div>
      </div>

      <div style="max-width: 840px; margin: 40px auto 0 auto; display: flex; flex-direction: column; gap: 24px;">
        <p class="about-summary-text"><?= nl2br(esc($unit['deskripsi'])) ?></p>
      </div>
    </div>
  </section>

  <!-- Galeri Foto -->
  <?php 
  $dokumentasi = json_decode($unit['dokumentasi'] ?? '[]', true) ?: []; 
  if (!empty($dokumentasi)):
  ?>
  <section class="section section-cream-dark" style="border-radius: 40px; margin: 40px 20px;">
    <div class="container">
      <div class="section-header center">
        <span class="designer-badge">Dokumentasi</span>
        <h2>Galeri <span><?= esc($unit['nama']) ?></span></h2>
        <p>Melihat lebih dekat kegiatan operasional kami dari hulu ke hilir.</p>
      </div>
      <div class="detail-gallery-grid">
        <?php foreach ($dokumentasi as $img): ?>
          <div class="detail-gallery-item">
            <img src="<?= base_url(esc($img)) ?>" alt="Dokumentasi <?= esc($unit['nama']) ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Lokasi Operasional -->
  <section class="section">
    <div class="container" style="max-width: 1000px;">
      <div class="section-header center">
        <span class="designer-badge">Alamat Operasional</span>
        <h2>Lokasi <span>Unit Bisnis</span></h2>
      </div>
      <div class="location-card">
        <div class="location-info-panel">
          <h3><?= esc($unit['nama']) ?></h3>
          <p style="color: var(--text-muted); line-height: 1.7; font-size: 1rem;">Berlokasi di <?= esc($unit['wilayah']) ?>.</p>
          <ul class="location-meta-list">
            <li class="location-meta-item">
              <svg class="location-meta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" />
              </svg>
              <span><?= esc($unit['alamat']) ?></span>
            </li>
            <li class="location-meta-item">
              <svg class="location-meta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.5 6.6,10.7L8.8,8.5C9,8.3 9.1,8 9.1,7.8C9.1,7.6 9,7.3 8.9,7.2C8.5,6.2 8.3,4.9 8.3,3.7C8.3,3.3 8,3 7.6,3H4.3C3.9,3 3.6,3.3 3.6,3.7C3.6,12.8 11,20.2 20.2,20.2C20.6,20.2 20.9,19.9 20.9,19.5V16.2C21,15.8 20.7,15.5 20,15.5Z" />
              </svg>
              <span><?= esc($unit['phone']) ?></span>
            </li>
            <li class="location-meta-item">
              <svg class="location-meta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22A9,9 0 0,0 21,13A9,9 0 0,0 12,4M12.5,8H11V14L15.75,16.85L16.5,15.62L12.5,13.25V8M7.88,3.39L6.6,1.86L2,5.71L3.29,7.24L7.88,3.39M22,5.72L17.4,1.86L16.11,3.39L20.71,7.25L22,5.72Z" />
              </svg>
              <span>Buka: <?= esc($unit['jam']) ?></span>
            </li>
          </ul>
        </div>
        <div class="location-map-mockup">
          <div class="location-map-grid-bg"></div>
          <svg class="location-map-pin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" />
          </svg>
          <span class="location-map-caption"><?= esc($unit['wilayah']) ?></span>
          <a href="<?= esc($unit['maps']) ?>" target="_blank"
            class="btn btn-terracotta location-map-btn">Buka di Google Maps</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Produk Terkait -->
  <section class="related-products-section section-cream-dark" style="border-radius: 40px; margin: 40px 20px;">
    <div class="container" style="max-width: 1200px;">
      <div class="section-header center">
        <span class="designer-badge">Belanja Langsung</span>
        <h2>Produk <span><?= esc($unit['nama']) ?></span></h2>
        <p>Lihat dan beli produk langsung dari unit bisnis kami.</p>
      </div>
      <div class="grid-4" id="products-catalog-grid" data-category="<?= esc($unit['id']) ?>">
        <!-- Injected dynamically by app.js -->
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
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path
          d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
      </svg>
    </button>
    <div class="modal-grid" id="modal-grid-content">
      <!-- Injected dynamically by app.js -->
    </div>
  </div>
</div>
<?= $this->endSection() ?>
