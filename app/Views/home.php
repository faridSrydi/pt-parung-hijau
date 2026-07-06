<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container">
  <!-- Cinematic Video Hero Section -->
  <section class="hero-video-section">
    <!-- Background Video -->
    <video autoplay loop muted playsinline
      style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">
      <source src="<?= base_url('assets/videos/forest.mp4') ?>" type="video/mp4">
    </video>

    <!-- Emerald Forest Overlay with Inner Vignette -->
    <div
      style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 37, 25, 0.4) 0%, rgba(7, 19, 12, 0.8) 100%); box-shadow: inset 0 0 100px rgba(0,0,0,0.6); z-index: 2;">
    </div>

    <!-- Decorative Ornate Inner Border with Custom Leaf Corners -->
    <div class="hero-video-border"
      style="position: absolute; top: 24px; left: 24px; right: 24px; bottom: 24px; border: 1px solid rgba(182, 138, 88, 0.25); border-radius: 36px; z-index: 3; pointer-events: none;">
      <!-- Corner Flourish Top-Left -->
      <svg viewBox="0 0 100 100"
        style="position: absolute; top: -2px; left: -2px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5;">
        <path d="M 0 50 C 0 20, 20 0, 50 0" />
        <path d="M 10 40 C 10 20, 20 10, 40 10" />
        <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
      </svg>

      <!-- Corner Flourish Top-Right -->
      <svg viewBox="0 0 100 100"
        style="position: absolute; top: -2px; right: -2px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scaleX(-1);">
        <path d="M 0 50 C 0 20, 20 0, 50 0" />
        <path d="M 10 40 C 10 20, 20 10, 40 10" />
        <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
      </svg>

      <!-- Corner Flourish Bottom-Left -->
      <svg viewBox="0 0 100 100"
        style="position: absolute; bottom: -2px; left: -2px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scaleY(-1);">
        <path d="M 0 50 C 0 20, 20 0, 50 0" />
        <path d="M 10 40 C 10 20, 20 10, 40 10" />
        <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
      </svg>

      <!-- Corner Flourish Bottom-Right -->
      <svg viewBox="0 0 100 100"
        style="position: absolute; bottom: -2px; right: -2px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scale(-1);">
        <path d="M 0 50 C 0 20, 20 0, 50 0" />
        <path d="M 10 40 C 10 20, 20 10, 40 10" />
        <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
      </svg>
    </div>

    <!-- Centered Content Wrapper -->
    <div class="container"
      style="position: relative; z-index: 4; text-align: center; max-width: 900px; color: var(--white); padding: 0 40px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
      <div class="hero-badge hero-fade-in"
        style="animation-delay: 0.2s; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px; background: rgba(182, 138, 88, 0.15); border: 1px solid rgba(182, 138, 88, 0.3); padding: 8px 24px; border-radius: 30px; font-family: var(--font-sans); font-weight: 700; font-size: 0.85rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--accent-light); margin-left: auto; margin-right: auto; width: fit-content; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        Selamat datang
      </div>

      <h1 class="hero-video-title hero-fade-in"
        style="animation-delay: 0.5s; font-family: var(--font-serif); font-weight: 500; color: var(--white); margin-bottom: 24px; line-height: 1.15; text-shadow: 0 4px 12px rgba(0,0,0,0.5);">
        di PT. Parung Hijau Perkasa
      </h1>

      <!-- Word-by-word appearing text container -->
      <p id="hero-animated-desc" class="hero-video-desc"
        style="font-family: var(--font-sans); font-weight: 300; line-height: 1.6; color: rgba(251, 249, 244, 0.9); margin-bottom: 40px; text-shadow: 0 2px 6px rgba(0,0,0,0.4);">
        <!-- Triggered by JS to split into span elements -->
      </p>

      <div class="hero-buttons hero-fade-in"
        style="animation-delay: 2.2s; display: flex; justify-content: center; gap: 20px;">
        <a href="<?= base_url('produk-kami') ?>" class="btn btn-terracotta"
          style="box-shadow: 0 10px 25px rgba(201, 125, 101, 0.3);">Jelajahi Produk</a>
        <a href="<?= base_url('tentang-kami') ?>" class="btn btn-outline"
          style="border-color: var(--white); color: var(--white); background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(5px);">Kisah Kami</a>
      </div>
    </div>
  </section>

  <!-- Tentang Kami Summary Section -->
  <section class="section" style="padding: 80px 0;">
    <div class="container" style="max-width: 900px; text-align: center; position: relative;">
      <!-- Custom Botanical Graphic / Separator -->
      <div class="reveal reveal-fade"
        style="margin-bottom: 30px; display: flex; justify-content: center; align-items: center; gap: 12px;">
        <div style="height: 1px; width: 60px; background-color: var(--accent);"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
          style="width: 24px; height: 24px; fill: var(--accent);">
          <path
            d="M17,8C8,10 5.9,16.17 3.82,21.34L2.18,20.66C4.26,15.5 6.34,9 17,8M21,2C21,2 14,3 10,8C10,8 14,14 17,14C17,14 20.5,5.5 21,2M17.5,7.25C17.09,7.25 16.75,6.91 16.75,6.5C16.75,6.09 17.09,5.75 17.5,5.75C17.91,5.75 18.25,6.09 18.25,6.5C18.25,6.91 17.91,7.25 17.5,7.25Z" />
        </svg>
        <div style="height: 1px; width: 60px; background-color: var(--accent);"></div>
      </div>

      <span class="designer-badge reveal reveal-slide-down" style="margin-bottom: 16px;">Sekilas Tentang Kami</span>
      <h2 class="reveal reveal-fade delay-1"
        style="font-family: var(--font-serif); font-size: 3rem; color: var(--primary); margin-bottom: 32px; font-weight: 500; letter-spacing: -0.015em;">
        Tentang Kami</h2>

      <div class="reveal reveal-slide-up delay-2"
        style="background: var(--white); border: 1px solid rgba(182, 138, 88, 0.3); border-radius: 40px 15px 40px 15px; padding: 55px 45px; box-shadow: var(--shadow-medium); position: relative; margin-bottom: 40px;">
        <!-- Inner decorative double border link -->
        <div
          style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px; border: 1px dashed rgba(182, 138, 88, 0.25); border-radius: 32px 10px 32px 10px; pointer-events: none;">
        </div>

        <!-- Custom Botanical Branches SVG Corner Flourishes -->
        <!-- Top-Left Corner -->
        <svg viewBox="0 0 100 100"
          style="position: absolute; top: 12px; left: 12px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; pointer-events: none;">
          <path d="M 0 50 C 0 20, 20 0, 50 0" />
          <path d="M 10 40 C 10 20, 20 10, 40 10" />
          <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
        </svg>

        <!-- Top-Right Corner -->
        <svg viewBox="0 0 100 100"
          style="position: absolute; top: 12px; right: 12px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scaleX(-1); pointer-events: none;">
          <path d="M 0 50 C 0 20, 20 0, 50 0" />
          <path d="M 10 40 C 10 20, 20 10, 40 10" />
          <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
        </svg>

        <!-- Bottom-Left Corner -->
        <svg viewBox="0 0 100 100"
          style="position: absolute; bottom: 12px; left: 12px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scaleY(-1); pointer-events: none;">
          <path d="M 0 50 C 0 20, 20 0, 50 0" />
          <path d="M 10 40 C 10 20, 20 10, 40 10" />
          <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
        </svg>

        <!-- Bottom-Right Corner -->
        <svg viewBox="0 0 100 100"
          style="position: absolute; bottom: 12px; right: 12px; width: 50px; height: 50px; fill: none; stroke: var(--accent); stroke-width: 1.5; transform: scale(-1); pointer-events: none;">
          <path d="M 0 50 C 0 20, 20 0, 50 0" />
          <path d="M 10 40 C 10 20, 20 10, 40 10" />
          <path d="M 15 28 C 18 20, 20 18, 28 15 C 22 22, 22 22, 15 28 Z" fill="var(--accent)" />
        </svg>

        <p class="about-summary-text">
          <strong>PT Parung Hijau Perkasa</strong>, yang berlokasi di Bogor, Jawa Barat, adalah perusahaan yang
          lahir dari semangat inovasi dan keberlanjutan. Didirikan pada 27 Maret 2020, perusahaan ini berkomitmen
          untuk berkontribusi pada peningkatan ekonomi lokal dan menjaga keseimbangan ekosistem melalui praktik
          pertanian, peternakan, perikanan, dan pengelolaan sampah yang ramah lingkungan.
        </p>
        <p class="about-summary-text" style="margin-bottom: 0;">
          Di tengah suburnya tanah Bogor, PT Parung Hijau Perkasa memanfaatkan potensi lokal dengan memberdayakan
          masyarakat setempat dan menerapkan teknologi modern yang berfokus pada keberlanjutan. Perusahaan ini
          bangga menjadi bagian dari komunitas yang dinamis dan turut serta dalam meningkatkan kesejahteraan ekonomi
          daerah serta menjaga kelestarian lingkungan untuk generasi mendatang.
        </p>
      </div>

      <a href="<?= base_url('tentang-kami') ?>" class="btn btn-terracotta reveal reveal-slide-up delay-3"
        style="padding: 16px 40px; box-shadow: 0 10px 25px rgba(201, 125, 101, 0.25);">
        Lihat Selengkapnya
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
          style="width: 20px; height: 20px; fill: white; margin-left: 8px;">
          <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
        </svg>
      </a>
    </div>
  </section>

  <!-- Key Pillars Section (Produk Kami / Unit Bisnis) -->
  <section class="section section-cream-dark" style="border-radius: 40px; margin: 40px 20px;">
    <div class="container">
      <div class="section-header center reveal reveal-slide-up">
        <span class="designer-badge">Produk Kami</span>
        <h2>Hasil Alam <span>Kualitas Premium</span></h2>
        <p>PT Parung Hijau Perkasa menghadirkan produk pangan dan layanan ramah lingkungan berkelanjutan bagi masyarakat.</p>
      </div>
      <div class="product-showcase-grid">
        <?php if (!empty($units)): ?>
          <?php $delay = 1; ?>
          <?php foreach ($units as $unit): ?>
            <div class="product-showcase-card reveal reveal-slide-up delay-<?= $delay ?>">
              <div class="product-showcase-img-container">
                <img src="<?= base_url(esc($unit['foto_sampul'] ?? 'assets/images/produk/ayam.jpg')) ?>" alt="<?= esc($unit['nama']) ?>">
              </div>
              <div class="product-showcase-content">
                <h4 class="product-showcase-title"><?= esc($unit['nama']) ?></h4>
                <p class="product-showcase-text">
                  <?= esc($unit['deskripsi']) ?>
                </p>
                <div style="margin-top: 16px;">
                  <a href="<?= base_url('unit-bisnis/' . esc($unit['id'])) ?>" class="btn btn-outline"
                    style="padding: 8px 18px; font-size: 0.8rem; border-radius: 30px;">Selengkapnya</a>
                </div>
              </div>
            </div>
            <?php 
              $delay++; 
              if ($delay > 4) $delay = 1;
            ?>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-muted w-100">Belum ada unit bisnis yang tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Slogan Call to Action Section -->
  <section class="section" style="padding: 80px 0;">
    <div class="container">
      <div class="waste-cta-card reveal reveal-slide-up">
        <!-- Inner decorative dashed border line -->
        <div class="waste-cta-inner-border"></div>

        <!-- Botanical leaf separator -->
        <div class="waste-cta-icon-wrapper">
          <div class="line"></div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M17,8C8,10 5.9,16.17 3.82,21.34L2.18,20.66C4.26,15.5 6.34,9 17,8M21,2C21,2 14,3 10,8C10,8 14,14 17,14C17,14 20.5,5.5 21,2M17.5,7.25C17.09,7.25 16.75,6.91 16.75,6.5C16.75,6.09 17.09,5.75 17.5,5.75C17.91,5.75 18.25,6.09 18.25,6.5C18.25,6.91 17.91,7.25 17.5,7.25Z" />
          </svg>
          <div class="line"></div>
        </div>

        <h2
          style="font-family: var(--font-serif); font-size: 2.5rem; font-weight: 500; color: var(--primary); line-height: 1.4; max-width: 800px; margin: 0 auto; position: relative; z-index: 2;">
          Mari bergabung bersama kami <span class="handwritten"
            style="font-size: 3.6rem; color: var(--accent); display: block; margin-top: 15px; transform: rotate(-1deg);">mengelola sampah organik!</span>
        </h2>
      </div>
    </div>
  </section>

  <!-- Circular Agribusiness Cycle Section -->
  <section class="section section-cream-dark reveal reveal-slide-up" style="border-radius: 40px; margin: 40px 20px;">
    <div class="container">
      <div class="section-header center">
        <span class="designer-badge">Sistem Berkelanjutan</span>
        <h2>Siklus <span>Agribisnis Sirkular</span></h2>
        <p>Bagaimana kami menghubungkan pengelolaan limbah, peternakan, dan pertanian menjadi ekosistem mandiri tanpa sisa (Zero Waste).</p>
      </div>

      <div class="cycle-grid">
        <!-- Step 1 -->
        <div class="cycle-card reveal reveal-slide-up delay-1">
          <span class="cycle-step-badge">Step 01</span>
          <div class="cycle-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M20,8H17V4H3C1.89,4 1,4.89 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8M6,18.5A1.5,1.5 0 1,1 7.5,17A1.5,1.5 0 0,1 6,18.5M18,18.5A1.5,1.5 0 1,1 19.5,17A1.5,1.5 0 0,1 18,18.5M17,12V10H19.5L21.2,12H17Z"/>
            </svg>
          </div>
          <h3 class="cycle-card-title">Pengumpulan Limbah</h3>
          <p class="cycle-card-desc">Limbah organik sisa makanan dikumpulkan dari mitra restoran & pasar untuk disalurkan ke fasilitas biokonversi.</p>
        </div>

        <!-- Step 2 -->
        <div class="cycle-card reveal reveal-slide-up delay-2">
          <span class="cycle-step-badge">Step 02</span>
          <div class="cycle-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M19,3H5C3.89,3 3,3.89 3,5V19C3,20.1 3.89,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.89 20.1,3 19,3M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M19,19H5V17C5,14.33 10.33,13 13,13C13.56,13 14.36,13.07 15.17,13.2C17.38,13.57 19,15.22 19,17.43V19Z"/>
            </svg>
          </div>
          <h3 class="cycle-card-title">Biokonversi BSF</h3>
          <p class="cycle-card-desc">Limbah diurai oleh larva BSF, menghasilkan maggot protein tinggi serta pupuk kompos murni berkualitas tinggi.</p>
        </div>

        <!-- Step 3 -->
        <div class="cycle-card reveal reveal-slide-up delay-3">
          <span class="cycle-step-badge">Step 03</span>
          <div class="cycle-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12,2C11.5,2 10,2.5 10,6C10,6.7 10.3,7.5 10.7,8.2L8.2,10.7C7.5,10.3 6.7,10 6,10C2.5,10 2,11.5 2,12C2,12.5 2.5,14 6,14C6.7,14 7.5,13.7 8.2,13.3L10.7,15.8C10.3,16.5 10,17.3 10,18C10,21.5 11.5,22 12,22C12.5,22 14,21.5 14,18C14,17.3 13.7,16.5 13.3,15.8L15.8,13.3C16.5,13.7 17.3,14 18,14C21.5,14 22,12.5 22,12C22,11.5 21.5,10 18,10C17.3,10 16.5,10.3 15.8,10.7L13.3,8.2C13.7,7.5 14,6.7 14,6C14,2.5 12.5,2 12,2Z"/>
            </svg>
          </div>
          <h3 class="cycle-card-title">Nutrisi Organik</h3>
          <p class="cycle-card-desc">Maggot menyuplai pakan bergizi ayam/patin Adiluhung, sementara kompos menyuburkan kebun Cavendish Sungrow.</p>
        </div>

        <!-- Step 4 -->
        <div class="cycle-card reveal reveal-slide-up delay-4">
          <span class="cycle-step-badge">Step 04</span>
          <div class="cycle-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
            </svg>
          </div>
          <h3 class="cycle-card-title">Pangan Premium</h3>
          <p class="cycle-card-desc">Hasil panen premium pisang Cavendish, ayam kampung, dan ikan patin segar berkualitas tinggi bagi masyarakat.</p>
        </div>
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
