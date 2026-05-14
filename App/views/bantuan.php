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
        <a href="index.php?route=katalog">Katalog Game</a>
        <a href="index.php?route=marketplace">Marketplace</a>
        <a href="index.php?route=bantuan" style="color: #ffd700; font-weight: bold">Bantuan</a>
      </nav>
      <div class="user-menu">
        <a href="index.php?route=masuk" class="btn-login">Masuk</a>
        <a href="index.php?route=daftar" class="btn-register">Daftar</a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Pusat Bantuan</h2>
        <p>Ada kendala atau pertanyaan? Tim kami siap membantu Anda.</p>
      </div>

      <div class="auth-container" style="margin-top: 20px;">
        <div class="auth-card" style="max-width: 800px;">
          <h3>Kirim Pesan ke Admin</h3>
          <form action="index.php" method="GET">
            <input type="hidden" name="route" value="masuk">
            <div class="form-group">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required />
            </div>

            <div class="form-group">
              <label class="form-label">Alamat Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email yang bisa dihubungi" required />
            </div>

            <div class="form-group">
              <label class="form-label">Kategori Kendala</label>
              <select name="kategori" class="form-control" required>
                <option value="Akun">Masalah Akun</option>
                <option value="Pembayaran">Kendala Pembayaran</option>
                <option value="Game">Masalah Teknis Game</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Pesan</label>
              <textarea name="pesan" class="form-control" rows="5" placeholder="Jelaskan detail masalah Anda..." required></textarea>
            </div>

            <button type="submit" class="btn-auth">Kirim Pesan</button>
          </form>
        </div>
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