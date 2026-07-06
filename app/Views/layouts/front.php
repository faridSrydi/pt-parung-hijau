<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="PT Parung Hijau Perkasa - Berkomitmen pada kemajuan ekonomi lokal dan keberlanjutan lingkungan di wilayah Bogor melalui pertanian, peternakan, perikanan, dan waste management.">
  <title><?= $title ?? 'PT Parung Hijau Perkasa' ?></title>
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/front-styles.css?v=7') ?>">
  <script>
    window.BASE_URL = '<?= base_url() ?>';
    <?php if (auth()->loggedIn()): 
      $userGroups = auth()->user()->getGroups();
      $role = !empty($userGroups) ? $userGroups[0] : 'pelanggan';
      $dashboardUrl = base_url($role . '/dashboard');
      if ($role === 'superadmin') $dashboardUrl = base_url('admin/dashboard');
      if ($role === 'developer') $dashboardUrl = base_url('admin/dashboard');
      if ($role === 'user' || $role === 'beta') $dashboardUrl = base_url('pelanggan/dashboard');
      
      $db = \Config\Database::connect();
      $dbAddresses = $db->table('alamat_pengiriman')
          ->where('user_id', auth()->id())
          ->orderBy('is_default', 'DESC')
          ->get()
          ->getResultArray();
      
      $dbAddressesMapped = array_map(function($addr) {
          return [
              'id' => (string)$addr['id'],
              'name' => $addr['recipient_name'],
              'phone' => $addr['phone'],
              'addressLine' => $addr['address_line'],
              'isDefault' => (bool)$addr['is_default']
          ];
      }, $dbAddresses);
    ?>
      window.USER_SESSION = {
        name: '<?= esc(auth()->user()->username) ?>',
        email: '<?= esc(auth()->user()->email) ?>',
        dashboardUrl: '<?= $dashboardUrl ?>'
      };
      
      // Sync DB addresses to LocalStorage for front-app.js
      (function() {
        let users = JSON.parse(localStorage.getItem('registeredUsers')) || [];
        let userIdx = users.findIndex(u => u.email === window.USER_SESSION.email);
        const mappedAddresses = <?= json_encode($dbAddressesMapped) ?>;
        
        if (userIdx === -1) {
          users.push({
            name: window.USER_SESSION.name,
            email: window.USER_SESSION.email,
            password: '',
            addresses: mappedAddresses
          });
        } else {
          users[userIdx].addresses = mappedAddresses;
        }
        localStorage.setItem('registeredUsers', JSON.stringify(users));
        localStorage.setItem('activeUser', JSON.stringify(window.USER_SESSION));
      })();
    <?php else: ?>
      window.USER_SESSION = null;
    <?php endif; ?>
    window.DB_PRODUCTS = <?= json_encode(\App\Controllers\Home::getDatabaseProductsFormatted()) ?>;
  </script>
</head>

<body>

  <!-- ==========================================================================
       SITE HEADER NAVIGATION (Glassmorphism Floating Header)
       ========================================================================== -->
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
            <!-- Rendered dynamically by app.js: Login link or profile dropdown -->
          </li>
        </ul>
      </nav>

      <div class="header-actions">
        <!-- Shopping Cart Icon Toggle -->
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

  <!-- ==========================================================================
       MAIN CONTENT (Rendered dynamically by CI4)
       ========================================================================== -->
  <main id="app-root">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- ==========================================================================
       SITE FOOTER (Organic Arched Boundary)
       ========================================================================== -->
  <footer class="site-footer">
    <!-- Site Footer Curve & Layout -->
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
          <div class="footer-social-row">
            <a href="#" class="social-circle" aria-label="Facebook">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.95 14.22 5.95C15.31 5.95 16.45 6.15 16.45 6.15V8.62H15.19C13.94 8.62 13.55 9.4 13.55 10.19V12.06H16.34L15.89 14.96H13.55V21.96C18.34 21.21 22 17.06 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
              </svg>
            </a>
            <a href="#" class="social-circle" aria-label="Instagram">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
              </svg>
            </a>
            <a href="#" class="social-circle" aria-label="Twitter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                  d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.59,4 11.64,5.95 11.64,8.35C11.64,8.7 11.68,9.03 11.76,9.36C8.12,9.18 4.91,7.44 2.76,4.81C2.37,5.48 2.15,6.26 2.15,7.08C2.15,8.59 2.92,9.93 4.09,10.71C3.38,10.69 2.71,10.49 2.13,10.17C2.13,10.19 2.13,10.2 2.13,10.22C2.13,12.33 3.63,14.09 5.62,14.49C5.26,14.58 4.88,14.64 4.49,14.64C4.21,14.64 3.94,14.61 3.68,14.56C4.23,16.29 5.84,17.55 7.74,17.59C6.25,18.75 4.38,19.44 2.34,19.44C1.99,19.44 1.65,19.42 1.3,19.38C3.22,20.62 5.5,21.35 7.95,21.35C15.93,21.35 20.3,14.74 20.3,9C20.3,8.81 20.3,8.62 20.29,8.43C21.14,7.82 21.87,7.05 22.46,6Z" />
              </svg>
            </a>
          </div>
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
              Bogor, Jawa Barat,<br>
              Indonesia
            </div>
          </div>
          <div class="footer-contact-item">
            <svg class="footer-contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path
                d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.5 6.6,10.7L8.8,8.5C9,8.3 9.1,8 9.1,7.8C9.1,7.6 9,7.3 8.9,7.2C8.5,6.2 8.3,4.9 8.3,3.7C8.3,3.3 8,3 7.6,3H4.3C3.9,3 3.6,3.3 3.6,3.7C3.6,12.8 11,20.2 20.2,20.2C20.6,20.2 20.9,19.9 20.9,19.5V16.2C21,15.8 20.7,15.5 20,15.5Z" />
            </svg>
            <div class="footer-contact-text">
              +62 251 8765 4321
            </div>
          </div>
          <div class="footer-contact-item">
            <svg class="footer-contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path
                d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6A2,2 0 0,0 20,4M20,8L12,13L4,8V6L12,11L20,6V8Z" />
            </svg>
            <div class="footer-contact-text">
              hello@parunghijauperkasa.com
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

  <!-- ==========================================================================
       BACK TO TOP BUTTON
       ========================================================================== -->
  <button id="back-to-top" class="back-to-top-btn" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;">
      <path d="M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z"/>
    </svg>
  </button>

  <!-- Application Logic -->
  <script src="<?= base_url('assets/js/front-app.js?v=7') ?>" defer></script>
</body>

</html>
