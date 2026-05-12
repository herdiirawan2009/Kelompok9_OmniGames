<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bantuan - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="katalog.php">Katalog Game</a>
        <a href="marketplace.php">Marketplace</a>
        <a href="bantuan.php" style="color: #ffd700; font-weight: bold">Bantuan</a>
      </nav>
      <div class="user-menu">
        <a href="masuk.php" class="btn-login">Masuk</a>
        <a href="daftar.php" class="btn-register">Daftar</a>
      </div>
    </header>

    <div class="catalog-header">
      <h2>Pusat Bantuan</h2>
    </div>

    <main class="container help-layout">
      <div class="faq-section">
        <h3>Pertanyaan yang Sering Diajukan</h3>

        <div class="faq-item">
          <h4 class="faq-question">Bagaimana cara membeli game di OMNIGAMES?</h4>
          <p class="faq-answer">
            Kamu cukup mencari game di halaman Katalog, klik tombol Beli Sekarang, lalu selesaikan proses pembayaran di halaman Marketplace.
          </p>
        </div>

        <div class="faq-item">
          <h4 class="faq-question">Apakah game yang dibeli bersifat permanen?</h4>
          <p class="faq-answer">
            Ya, seluruh game digital yang kamu beli akan tersimpan secara permanen di akun OMNIGAMES milikmu dan bisa diunduh kapan saja.
          </p>
        </div>
        
        </div>

      <div class="contact-section">
        <h3>Hubungi Admin</h3>
        <form action="proses_kontak.php" method="POST">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama kamu" required />
          </div>

          <div class="form-group">
            <label class="form-label">Alamat Email</label>
            <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required />
          </div>

          <div class="form-group">
            <label class="form-label">Kategori Masalah</label>
            <select name="kategori" class="form-control">
              <option value="transaksi">Masalah Transaksi</option>
              <option value="akun">Kendala Akun</option>
              <option value="teknis">Masalah Teknis Game</option>
              <option value="lainnya">Pertanyaan Lainnya</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Pesan / Detail Masalah</label>
            <textarea name="pesan" class="form-control" placeholder="Jelaskan masalah yang kamu alami secara detail..." required></textarea>
          </div>

          <button type="submit" class="btn-submit">Kirim Pesan</button>
        </form>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <h3>OMNIGAMES</h3>
        <p>Platform marketplace dan portal informasi game digital terpercaya di Indonesia.</p>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> OMNIGAMES Project. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>