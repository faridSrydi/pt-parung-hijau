<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->renderSection('title') ?> | PT Parung Hijau Perkasa</title>
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/front-styles.css?v=7') ?>">
  <style>
    .site-footer {
      margin-top: 140px !important;
    }
  </style>
  <script>
    window.BASE_URL = '<?= base_url() ?>';
    <?php if (auth()->loggedIn()): ?>
      window.USER_SESSION = {
        name: '<?= esc(auth()->user()->username) ?>',
        email: '<?= esc(auth()->user()->email) ?>'
      };
    <?php else: ?>
      window.USER_SESSION = null;
    <?php endif; ?>
  </script>
</head>

<body>

  <!-- SITE HEADER NAVIGATION -->
  <header class="site-header" id="site-header">
    <div class="header-container">
      <a href="<?= base_url() ?>" class="logo">
        <div class="logo-highlight">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Parung Hijau Perkasa"
            style="height: 48px; width: auto; object-fit: contain;">
        </div>
        <span>Parung Hijau Perkasa</span>
      </a>

      <nav>
        <ul class="nav-menu" id="nav-menu">
          <li><a href="<?= base_url() ?>" class="nav-link" id="nav-home">Beranda</a></li>
          <li><a href="<?= base_url('tentang-kami') ?>" class="nav-link" id="nav-about">Tentang Kami</a></li>
          <li><a href="<?= base_url('produk-kami') ?>" class="nav-link" id="nav-products">Produk Kami</a></li>
          <li><a href="<?= base_url('kontak') ?>" class="nav-link" id="nav-contact">Kontak</a></li>
          <li id="header-user-menu" class="user-menu-item">
            <!-- Rendered dynamically by app.js -->
          </li>
        </ul>
      </nav>

      <div class="header-actions">
        <button class="cart-toggle-btn" id="cart-toggle-btn" aria-label="Buka Keranjang" style="margin-right: 12px;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;">
            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18M7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7A2,2 0 0,1 5,15C5,14.65 5.07,14.31 5.24,14L6.6,11.59L3,4H1V2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.64,11.36C17.29,11.97 16.64,12.37 15.9,12.37H8.1L7.2,14.63Z"/>
          </svg>
          <span class="cart-count-badge" id="cart-badge-count" style="display: none;">0</span>
        </button>

        <a href="<?= base_url('produk-kami') ?>" class="btn btn-primary" style="padding: 10px 24px; font-size: 0.9rem;">Belanja</a>
        
        <button class="mobile-nav-toggle" id="mobile-nav-toggle" aria-label="Toggle Menu">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
      </div>
    </div>
  </header>

  <!-- CONTENT CONTAINER -->
  <main id="app-root">
    <div class="page-container fade-in" id="page-container">
      <section class="auth-section">
        <div class="auth-card reveal reveal-slide-up">
          <!-- Gold Corner Brackets -->
          <div class="corner-decor corner-tl"></div>
          <div class="corner-decor corner-tr"></div>
          <div class="corner-decor corner-bl"></div>
          <div class="corner-decor corner-br"></div>

          <!-- Brand Header inside Card -->
          <div style="text-align: center; margin-bottom: 30px;">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="PT Parung Hijau Perkasa"
              style="height: 52px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));">
            <h2
              style="font-family: var(--font-serif); font-size: 1.6rem; font-weight: 500; color: var(--primary); margin-top: 10px; letter-spacing: -0.01em;">
              Parung Hijau Perkasa</h2>
            <p
              style="font-family: var(--font-cursive); font-size: 1.8rem; color: var(--accent-dark); margin-top: 4px; transform: rotate(-2deg); line-height: 1;">
              Pintu Gerbang Berkelanjutan</p>
          </div>

          <?= $this->renderSection('main') ?>

        </div>
      </section>

      <!-- Decorative Slogan Area to Fill the Cream Gap -->
      <div class="auth-slogan-container reveal reveal-slide-up delay-1" style="text-align: center; padding: 0 20px; max-width: 800px; margin: 70px auto 0 auto;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 12px;">
          <div style="height: 1px; width: 60px; background: rgba(182, 138, 88, 0.35);"></div>
          <span class="handwritten" style="font-size: 2.2rem; color: var(--accent); transform: rotate(-1deg); display: inline-block;">Sejak 2020</span>
          <div style="height: 1px; width: 60px; background: rgba(182, 138, 88, 0.35);"></div>
        </div>
        <h3 style="font-family: var(--font-serif); font-size: 1.8rem; font-weight: 500; color: var(--primary); margin: 0; letter-spacing: -0.01em; line-height: 1.4;">
          Menumbuhkan Kemakmuran Alami, Melindungi Bumi Lestari
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 10px; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700;">
          Pertanian &bull; Peternakan &bull; Perikanan &bull; Pengelolaan Limbah
        </p>
      </div>

    </div>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer">
    <svg class="footer-top-curve" viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,100 C280,30 560,0 800,0 C1040,0 1200,30 1440,100 Z" />
    </svg>

    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <div class="footer-logo">
            <div class="logo-highlight">
              <img src="<?= base_url('assets/images/logo.png') ?>" alt="Parung Hijau Perkasa"
                style="height: 44px; width: auto; object-fit: contain;">
            </div>
            <span>Parung Hijau Perkasa</span>
          </div>
          <p>Membangun masa depan berkelanjutan melalui inovasi di bidang pertanian, peternakan, perikanan, dan pengelolaan lingkungan.</p>
        </div>

        <div class="footer-col">
          <h3>Halaman</h3>
          <ul class="footer-links">
            <li><a href="<?= base_url() ?>" class="footer-link">Beranda</a></li>
            <li><a href="<?= base_url('tentang-kami') ?>" class="footer-link">Tentang Kami</a></li>
            <li><a href="<?= base_url('produk-kami') ?>" class="footer-link">Produk Kami</a></li>
            <li><a href="<?= base_url('kontak') ?>" class="footer-link">Kontak</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h3>Bantuan</h3>
          <ul class="footer-links">
            <li><a href="<?= base_url('kontak') ?>" class="footer-link">FAQs</a></li>
            <li><a href="<?= base_url('kontak') ?>" class="footer-link">Kebijakan Privasi</a></li>
            <li><a href="<?= base_url('kontak') ?>" class="footer-link">Syarat & Ketentuan</a></li>
            <li><a href="<?= base_url('kontak') ?>" class="footer-link">Layanan Pelanggan</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h3>Kontak Kami</h3>
          <div class="footer-contact-item">
            <svg class="footer-contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path
                d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" />
            </svg>
            <div class="footer-contact-text">
              <strong>PT Parung Hijau Perkasa</strong><br>
              Bogor, Jawa Barat, Indonesia
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div class="footer-copy">
          &copy; 2026 PT Parung Hijau Perkasa. Hak Cipta Dilindungi.
        </div>
      </div>
    </div>
  </footer>

  <script src="<?= base_url('assets/js/front-app.js?v=7') ?>" defer></script>
</body>

</html>
