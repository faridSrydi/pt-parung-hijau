<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container">
  <!-- Header Banner -->
  <section class="section section-primary"
    style="padding: 100px 0; text-align: center; border-radius: 30px; margin: 0 20px 80px 20px;">
    <div class="container">
      <span class="designer-badge"
        style="background: rgba(255,255,255,0.08); color: var(--accent-light); border-color: rgba(255,255,255,0.2);">Hubungan Pelanggan</span>
      <h1 style="color: var(--white); font-size: 3.8rem; font-weight: 500; margin-top: 15px;">Kontak Kami<br><span
          class="handwritten"
          style="color: var(--accent-light); font-size: 3.2rem; transform: rotate(-3deg); margin-top: 10px; display: block;">PT Parung Hijau Perkasa</span></h1>
    </div>
  </section>

  <section class="section" style="padding-top: 20px; padding-bottom: 120px;">
    <div class="container" style="position: relative;">
      <!-- Handwritten decorative annotation -->
      <div class="handwritten-annotation reveal reveal-slide-up delay-1" style="top: -35px; left: 24px; font-size: 1.8rem; color: var(--accent-dark); transform: rotate(-4deg); z-index: 5;">
        Petunjuk Arah & Lokasi 📍
      </div>

      <div class="contact-wrapper grid-2 reveal reveal-slide-up">

        <!-- Contact Map Panel with Nested Card -->
        <div class="contact-map-panel">
          <div class="contact-map-card-nested">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15659.59991585598!2d106.767927!3d-6.191217000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f71dab003663%3A0x81fccdeca0f88367!2sAKR%20Tower%2C%20RT.11%2FRW.10%2C%20Kb.%20Jeruk%2C%20Kec.%20Kb.%20Jeruk%2C%20Kota%20Jakarta%20Barat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2011530!5e1!3m2!1sen!2sid!4v1782920604781!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
          </div>
        </div>

        <!-- Contact Details Panel -->
        <div class="contact-info-panel">
          <div>
            <span class="designer-badge"
              style="background: rgba(255,255,255,0.08); color: var(--accent-light); border-color: rgba(255,255,255,0.2);">Showroom
              Kontak</span>
            <h2 class="contact-info-title">Hubungi Kami</h2>
            <p style="color: rgba(251,249,244,0.75);">Konsultasikan kebutuhan produk pertanian, peternakan,
              perikanan, atau pengelolaan limbah Anda dengan tim representative kami. Kami siap melayani dengan
              ketulusan hati.</p>

            <div class="contact-details-list">
              <div class="contact-detail-item">
                <div class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                      d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" />
                  </svg>
                </div>
                <div class="contact-detail-text">
                  <h4>Showroom Utama</h4>
                  <p>AKR Tower, Jl. Panjang No.5, Kb. Jeruk, Kota Jakarta Barat, Jakarta 11530</p>
                </div>
              </div>
              <div class="contact-detail-item">
                <div class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                      d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.5 6.6,10.7L8.8,8.5C9,8.3 9.1,8 9.1,7.8C9.1,7.6 9,7.3 8.9,7.2C8.5,6.2 8.3,4.9 8.3,3.7C8.3,3.3 8,3 7.6,3H4.3C3.9,3 3.6,3.3 3.6,3.7C3.6,12.8 11,20.2 20.2,20.2C20.6,20.2 20.9,19.9 20.9,19.5V16.2C21,15.8 20.7,15.5 20,15.5Z" />
                  </svg>
                </div>
                <div class="contact-detail-text">
                  <h4>Telepon / WhatsApp Resmi</h4>
                  <p>+62 251 8765 4321</p>
                </div>
              </div>
              <div class="contact-detail-item">
                <div class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                      d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6A2,2 0 0,0 20,4M20,8L12,13L4,8V6L12,11L20,6V8Z" />
                  </svg>
                </div>
                <div class="contact-detail-text">
                  <h4>Email Pelanggan</h4>
                  <p>hello@parunghijauperkasa.com</p>
                </div>
              </div>
            </div>
          </div>

          <div class="contact-socials">
            <a href="#" class="social-circle" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path fill="var(--white)"
                  d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.95 14.22 5.95C15.31 5.95 16.45 6.15 16.45 6.15V8.62H15.19C13.94 8.62 13.55 9.4 13.55 10.19V12.06H16.34L15.89 14.96H13.55V21.96C18.34 21.21 22 17.06 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
              </svg></a>
            <a href="#" class="social-circle" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path fill="var(--white)"
                  d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
              </svg></a>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>
