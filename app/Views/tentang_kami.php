<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="page-container fade-in" id="page-container">
  <!-- Header Banner -->
  <section class="section section-primary"
    style="padding: 100px 0; text-align: center; border-radius: 30px; margin: 0 20px 80px 20px;">
    <div class="container">
      <span class="designer-badge"
        style="background: rgba(255,255,255,0.08); color: var(--accent-light); border-color: rgba(255,255,255,0.2);">Profil
        Perusahaan</span>
      <h1 style="color: var(--white); font-size: 3.8rem; font-weight: 500; margin-top: 15px;">Tentang Kami<br><span
          class="handwritten"
          style="color: var(--accent-light); font-size: 3.2rem; transform: rotate(-3deg); margin-top: 10px; display: block;">PT
          Parung Hijau Perkasa</span></h1>
    </div>
  </section>
  <!-- Brand Story -->
  <section class="section" style="padding-top: 20px;">
    <div class="container" style="max-width: 960px;">
      <!-- Landscape image wrapper -->
      <div class="hero-image-wrapper reveal reveal-slide-up" style="margin-bottom: 50px; padding: 0;">
        <div class="designer-arch-frame" style="padding: 10px;">
          <div style="border: 1px solid var(--accent); border-radius: 30px; padding: 8px;">
            <div
              style="border: 2px solid rgba(15, 37, 25, 0.15); border-radius: 22px; overflow: hidden; height: 450px; width: 100%;">
              <img src="<?= base_url('assets/images/about.jpg') ?>" alt="PT Parung Hijau Perkasa"
                style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 12s ease;">
            </div>
          </div>
        </div>
        <!-- Subtitle under the image -->
        <div style="text-align: center; margin-top: 30px; position: relative;">
          <h2 style="font-size: 2.5rem; font-weight: 500; color: var(--primary); letter-spacing: -0.01em;">PT Parung
            Hijau Perkasa</h2>
          <div class="handwritten-annotation"
            style="bottom: -28px; left: 50%; transform: translateX(-50%) rotate(-4deg); font-size: 1.8rem;">
            Didirikan 27 Maret 2020
          </div>
        </div>
      </div>

      <!-- Centered Story Content Below -->
      <div style="max-width: 840px; margin: 60px auto 0 auto; display: flex; flex-direction: column; gap: 24px;" class="reveal reveal-slide-up delay-1">
        <p style="font-size: 1.1rem; line-height: 1.85; color: var(--text-muted); text-align: justify;">PT Parung
          Hijau Perkasa adalah perusahaan yang berdiri pada tanggal 27 Maret 2020 dan berlokasi di Bogor, Jawa
          Barat. Sejak awal pendiriannya, perusahaan ini telah berkomitmen untuk berkontribusi pada peningkatan
          ekonomi lokal dan keberlanjutan lingkungan. Beroperasi di daerah yang kaya akan sumber daya alam, PT
          Parung Hijau Perkasa memanfaatkan potensi lokal dengan memberdayakan masyarakat setempat dan menerapkan
          praktik pertanian serta pengelolaan sumber daya yang berkelanjutan. Dengan fokus pada pertanian,
          peternakan, perikanan, dan pengelolaan sampah, perusahaan ini tidak hanya menciptakan lapangan kerja,
          tetapi juga berperan penting dalam menjaga keseimbangan ekosistem di wilayah Bogor dan seampung.</p>

        <p style="font-size: 1.1rem; line-height: 1.85; color: var(--text-muted); text-align: justify;">Selain
          pertanian, sektor peternakan juga menjadi salah satu fokus utama PT Parung Hijau Perkasa, terutama dalam
          budidaya ayam kampung. Ayam kampung dari perusahaan ini dipelihara dengan metode organik, tanpa penggunaan
          antibiotik atau hormon, sehingga menghasilkan daging ayam yang sehat dan berkualitas tinggi. Ayam kampung
          dikenal memiliki daging yang lebih padat dan rasa yang lebih gurih dibandingkan dengan ayam broiler.
          Melalui budidaya ayam kampung ini, PT Parung Hijau Perkasa tidak hanya berkontribusi pada pemenuhan
          kebutuhan protein hewani bagi masyarakat, tetapi juga memberikan dampak ekonomi yang signifikan bagi
          peternak di sekitar Bogor.</p>

        <p style="font-size: 1.1rem; line-height: 1.85; color: var(--text-muted); text-align: justify;">Salah satu
          produk unggulan dari PT Parung Hijau Perkasa adalah Pisang Cavendish. Perusahaan ini memiliki kebun pisang
          yang dikelola dengan teknologi modern dan praktik pertanian yang berkelanjutan untuk memastikan hasil
          panen yang optimal. Pisang Cavendish yang diproduksi memiliki ukuran yang seragam, kulit yang mulus, serta
          rasa yang manis dan lezat. Dengan kualitas unggul tersebut, produk ini tidak hanya memenuhi permintaan
          pasar domestik, tetapi juga mulai merambah ke pasar ekspor. Keberhasilan produksi pisang ini telah
          memberikan dampak positif terhadap peningkatan ekonomi di daerah Bogor, serta membantu memperkuat posisi
          Indonesia sebagai produsen buah tropis berkualitas di kancah internasional.</p>

        <p style="font-size: 1.1rem; line-height: 1.85; color: var(--text-muted); text-align: justify;">Di sektor
          perikanan, PT Parung Hijau Perkasa fokus pada budidaya ikan patin, yang merupakan salah satu jenis ikan
          air tawar yang banyak diminati di Indonesia. Dengan memanfaatkan teknologi budidaya modern dan menerapkan
          standar kebersihan yang tinggi, perusahaan ini berhasil memproduksi ikan patin dengan kualitas terbaik.
          Ikan patin dari PT Parung Hijau Perkasa dikenal karena tekstur dagingnya yang lembut, kandungan proteinnya
          yang tinggi, serta rasanya yang gurih. Selain memenuhi kebutuhan pasar lokal, produksi ikan patin ini juga
          memberikan dampak ekonomi yang signifikan dengan memberdayakan petani ikan di sekitar Bogor.</p>

        <p style="font-size: 1.1rem; line-height: 1.85; color: var(--text-muted); text-align: justify;">Tidak hanya
          fokus pada produksi pangan, PT Parung Hijau Perkasa juga memiliki program pengelolaan sampah organik
          melalui metode waste management yang inovatif. Limbah organik dari proses produksi pertanian dan
          peternakan diolah menjadi pakan ternak dan maggot. Maggot, yang dihasilkan dari limbah organik, merupakan
          sumber protein tinggi yang digunakan sebagai pakan alternatif untuk unggas dan ikan. Program ini tidak
          hanya mengurangi volume sampah yang berakhir di tempat pembuangan akhir, tetapi juga memberikan nilai
          tambah dengan menghasilkan produk yang dapat digunakan kembali dalam rantai produksi. Dengan demikian, PT
          Parung Hijau Perkasa turut berperan dalam menjaga kelestarian lingkungan sembari mendukung pertumbuhan
          ekonomi lokal.</p>
      </div>
    </div>
  </section>

  <!-- Visi & Misi Section -->
  <section class="section section-cream-dark reveal reveal-slide-up" style="border-radius: 40px; margin: 40px 20px;">
    <div class="container">
      <div class="section-header center">
        <span class="designer-badge">Arah Langkah</span>
        <h2>Visi & Misi <span>Perusahaan</span></h2>
        <p>Bagaimana kami melangkah maju untuk mewujudkan keberlanjutan ekologi dan kesejahteraan masyarakat.</p>
      </div>
      <div class="grid-2">
        <!-- Visi Card -->
        <div class="vision-mission-card reveal reveal-slide-up delay-1">
          <div class="corner-decor corner-tl"></div>
          <div class="corner-decor corner-tr"></div>
          <span class="designer-badge" style="margin-bottom: 20px;">Arah Utama</span>
          <h3 class="vision-mission-title">Visi</h3>
          <p class="vision-mission-text" style="font-style: italic;">"Menjadi perusahaan terkemuka di bidang
            pertanian, peternakan, perikanan dan pengelolaan sampah dengan mengedepankan keberlanjutan lingkungan
            dan kesejahteraan masyarakat."</p>
        </div>

        <!-- Misi Card -->
        <div class="vision-mission-card reveal reveal-slide-up delay-2">
          <div class="corner-decor corner-bl"></div>
          <div class="corner-decor corner-br"></div>
          <span class="designer-badge" style="margin-bottom: 20px;">Misi Strategis</span>
          <h3 class="vision-mission-title">Misi</h3>
          <ul class="botanical-list">
            <li class="botanical-item">
              Menghasilkan produk berkualitas tinggi dengan proses produksi yang ramah lingkungan.
            </li>
            <li class="botanical-item">
              Memberikan nilai tambah kepada masyarakat melalui produk-produk yang berkualitas.
            </li>
            <li class="botanical-item">
              Mengembangkan inovasi teknologi untuk meningkatkan efisiensi produksi dan mengurangi dampak
              lingkungan.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Nilai Perusahaan Section -->
  <section class="section reveal reveal-slide-up">
    <div class="container">
      <div class="section-header center">
        <span class="designer-badge">Etika Kerja</span>
        <h2>Nilai-Nilai <span>Perusahaan</span></h2>
        <p>Fondasi utama yang menjiwai setiap langkah kerja dan keputusan bisnis di PT Parung Hijau Perkasa.</p>
      </div>
      <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 40px;">

        <div class="reveal reveal-slide-up delay-1"
          style="background: var(--white); padding: 36px 24px; text-align: center; border-radius: 20px 8px; border: 1px solid rgba(182,138,88,0.2); box-shadow: var(--shadow-soft); transition: var(--transition-fast);"
          onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
          <div
            style="font-family: var(--font-serif); font-size: 2.5rem; color: var(--accent); font-style: italic; margin-bottom: 10px;">
            01</div>
          <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary);">Berkelanjutan</h4>
        </div>

        <div class="reveal reveal-slide-up delay-2"
          style="background: var(--white); padding: 36px 24px; text-align: center; border-radius: 20px 8px; border: 1px solid rgba(182,138,88,0.2); box-shadow: var(--shadow-soft); transition: var(--transition-fast);"
          onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
          <div
            style="font-family: var(--font-serif); font-size: 2.5rem; color: var(--accent); font-style: italic; margin-bottom: 10px;">
            02</div>
          <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary);">Berkualitas</h4>
        </div>

        <div class="reveal reveal-slide-up delay-3"
          style="background: var(--white); padding: 36px 24px; text-align: center; border-radius: 20px 8px; border: 1px solid rgba(182,138,88,0.2); box-shadow: var(--shadow-soft); transition: var(--transition-fast);"
          onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
          <div
            style="font-family: var(--font-serif); font-size: 2.5rem; color: var(--accent); font-style: italic; margin-bottom: 10px;">
            03</div>
          <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary);">Inovatif</h4>
        </div>

        <div class="reveal reveal-slide-up delay-4"
          style="background: var(--white); padding: 36px 24px; text-align: center; border-radius: 20px 8px; border: 1px solid rgba(182,138,88,0.2); box-shadow: var(--shadow-soft); transition: var(--transition-fast);"
          onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
          <div
            style="font-family: var(--font-serif); font-size: 2.5rem; color: var(--accent); font-style: italic; margin-bottom: 10px;">
            04</div>
          <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary);">Bertanggung jawab</h4>
        </div>

        <div class="reveal reveal-slide-up delay-5"
          style="background: var(--white); padding: 36px 24px; text-align: center; border-radius: 20px 8px; border: 1px solid rgba(182,138,88,0.2); box-shadow: var(--shadow-soft); transition: var(--transition-fast);"
          onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
          <div
            style="font-family: var(--font-serif); font-size: 2.5rem; color: var(--accent); font-style: italic; margin-bottom: 10px;">
            05</div>
          <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--primary); line-height: 1.3;">Berorientasi
            pada masyarakat</h4>
        </div>

      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>
