<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar - OMNIGAMES</title>
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
        <a href="index.php?route=bantuan">Bantuan</a>
      </nav>

      <div class="user-menu">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="index.php?route=admin_dashboard" class="btn-register" style="background-color: #ffd700; color: #000; font-weight: bold; margin-right: 10px;">Panel Admin</a>
          <?php endif; ?>
          <a href="index.php?route=profil" class="btn-register" style="background-color: transparent; color: #ffd700; border: 1px solid #ffd700; font-weight: bold;">Profil Saya</a>
          <a href="index.php?route=keluar" class="btn-login">Keluar</a>
        <?php else: ?>
          <a href="index.php?route=masuk" class="btn-login">Masuk</a>
          <a href="index.php?route=daftar" class="btn-register">Daftar</a>
        <?php endif; ?>
      </div>
    </header>

    <main class="container auth-container">
      <div class="auth-card">
        <h2>Buat Akun Baru</h2>

        <form action="index.php?route=proses_daftar" method="POST">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required />
          </div>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required />
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Buat password" required />
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required />
          </div>

          <div class="form-group">
            <label class="form-label">Daftar Sebagai</label>
            <select name="role" class="form-control" required>
              <option value="user">Pembeli / User</option>
              <option value="developer">Penjual / Developer</option>
              <option value="admin">Administrator</option>
            </select>
          </div>

          <button type="submit" class="btn-auth">Daftar Sekarang</button>
        </form>

        <div class="auth-links">
          <p>Sudah punya akun? <a href="index.php?route=masuk">Masuk di sini</a></p>
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