<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container" style="padding-top: 100px;">
  <section class="section" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
      <div class="section-header center reveal reveal-slide-up">
        <span class="designer-badge" style="background: rgba(182, 138, 88, 0.1); color: var(--accent); border-color: rgba(182, 138, 88, 0.2);">Transaksi Aman</span>
        <h2 style="font-family: var(--font-serif); color: var(--primary); margin-top: 10px;">Checkout <span>Pesanan</span></h2>
        <p>Selesaikan pembelian produk segar Anda dengan mengisi data alamat pengiriman di bawah ini.</p>
      </div>

      <div class="checkout-grid" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; margin-top: 40px; align-items: start;">
        
        <!-- Form Pengiriman -->
        <div class="checkout-form-card" style="background: var(--white); border: 1px solid rgba(182, 138, 88, 0.2); border-radius: 24px; padding: 40px; box-shadow: var(--shadow-medium); position: relative;">
          <div class="corner-decor corner-tl"></div>
          <div class="corner-decor corner-tr"></div>
          
          <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 24px; font-size: 1.5rem;">Informasi Pengiriman</h3>
          
          <!-- Saved Address Select Container -->
          <div id="checkout-address-select-container"></div>
          
          <form id="checkout-order-form" onsubmit="submitCheckoutOrder(event)">
            <div class="form-group" style="margin-bottom: 18px;">
              <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block; font-size: 0.9rem;">Nama Penerima <span style="color: red;">*</span></label>
              <input type="text" id="checkout-name" required class="auth-input" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid rgba(182, 138, 88, 0.35); font-family: var(--font-sans);" placeholder="Nama lengkap penerima barang">
            </div>
            
            <div class="form-group" style="margin-bottom: 18px;">
              <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block; font-size: 0.9rem;">Nomor Telepon / WhatsApp <span style="color: red;">*</span></label>
              <input type="tel" id="checkout-phone" required class="auth-input" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid rgba(182, 138, 88, 0.35); font-family: var(--font-sans);" placeholder="Nomor telepon aktif (misal: 0812345678)">
            </div>
            
            <div class="form-group" style="margin-bottom: 18px;">
              <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block; font-size: 0.9rem;">Alamat Pengiriman <span style="color: red;">*</span></label>
              <textarea id="checkout-address" required class="auth-input" style="width: 100%; height: 100px; padding: 12px; border-radius: 10px; border: 1px solid rgba(182, 138, 88, 0.35); font-family: var(--font-sans); resize: none;" placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, kota, kode pos"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 24px;">
              <label class="auth-label" style="color: var(--primary); margin-bottom: 8px; display: block; font-size: 0.9rem;">Catatan Pengiriman (Opsional)</label>
              <input type="text" id="checkout-notes" class="auth-input" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid rgba(182, 138, 88, 0.35); font-family: var(--font-sans);" placeholder="Contoh: Titipkan di pos satpam, pagar warna hitam">
            </div>

            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 30px;">
              <input type="checkbox" id="checkout-save-address-checkbox" style="width: 16px; height: 16px; cursor: pointer;">
              <label for="checkout-save-address-checkbox" style="font-size: 0.88rem; color: var(--text-muted); cursor: pointer; user-select: none;">Simpan alamat ini ke daftar alamat saya</label>
            </div>

            <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 20px; font-size: 1.5rem;">Metode Pembayaran</h3>
            
            <div class="payment-options-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
              <div class="payment-card selected" id="checkout-pay-opt-auto" onclick="switchCheckoutPaymentMethod('auto')" style="padding: 16px; border-radius: 16px; cursor: pointer; transition: all 0.2s;">
                <h4 style="font-size: 1.05rem; color: var(--primary); margin-bottom: 6px; font-weight: 700;">Otomatis (PG)</h4>
                <p style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.3; margin: 0;">Selesaikan transaksi cepat otomatis via Payment Simulator.</p>
              </div>
              <div class="payment-card" id="checkout-pay-opt-manual" onclick="switchCheckoutPaymentMethod('manual')" style="padding: 16px; border-radius: 16px; cursor: pointer; transition: all 0.2s;">
                <h4 style="font-size: 1.05rem; color: var(--primary); margin-bottom: 6px; font-weight: 700;">Transfer Manual</h4>
                <p style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.3; margin: 0;">Transfer Bank Mandiri secara manual & unggah resi resminya.</p>
              </div>
            </div>
            
            <button type="submit" class="btn btn-terracotta" id="checkout-submit-btn" style="width: 100%; border-radius: 30px; padding: 16px; font-weight: 700; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(201, 125, 101, 0.35); border: none; color: var(--white); cursor: pointer;">
              Buat Pesanan
            </button>
          </form>
        </div>
        
        <!-- Summary Belanja -->
        <div class="checkout-summary-card" style="background: var(--white); border: 1px solid rgba(182, 138, 88, 0.2); border-radius: 24px; padding: 40px; box-shadow: var(--shadow-medium); position: relative;">
          <div class="corner-decor corner-bl"></div>
          <div class="corner-decor corner-br"></div>
          
          <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 24px; font-size: 1.5rem;">Daftar Belanja</h3>
          
          <div class="checkout-items-list" id="checkout-items-list-container" style="max-height: 400px; overflow-y: auto; padding-right: 5px; margin-bottom: 20px;">
            <!-- Injected dynamically by JS -->
          </div>
          
          <div style="border-top: 2px dashed rgba(182, 138, 88, 0.3); padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text-muted); font-size: 0.95rem;">
              <span>Total Barang:</span>
              <span id="checkout-qty-total" style="font-weight: 600;">0 Pcs</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; color: var(--text-muted); font-size: 0.95rem;">
              <span>Ongkos Kirim:</span>
              <span style="color: green; font-weight: 600;">GRATIS</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(182, 138, 88, 0.15); padding-top: 15px; margin-top: 10px;">
              <span style="font-weight: 700; color: var(--primary); font-size: 1.1rem;">Total Tagihan:</span>
              <span id="checkout-total-label" style="font-weight: 800; color: var(--accent); font-size: 1.25rem;">Rp 0</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>
