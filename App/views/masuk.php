<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk - OMNIGAMES</title>
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
        <a href="bantuan.php">Bantuan</a>
      </nav>
      <div class="user-menu">
        <a
          href="masuk.php"
          class="btn-login"
          style="background-color: #ffd700; color: #000000; font-weight: bold"
        >Masuk</a>
        <a href="daftar.php" class="btn-register">Daftar</a>
      </div>
    </header>

    <main class="container auth-container">
      <div class="auth-card">
        <h2>Masuk ke Akun</h2>

        <?php if(isset($_SESSION['error_login'])): ?>
            <div style="color: #ff4d4d; background: rgba(255, 77, 77, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php 
                    echo $_SESSION['error_login']; 
                    unset($_SESSION['error_login']); // Hapus pesan setelah ditampilkan
                ?>
            </div>
        <?php endif; ?>

        <form action="proses_masuk.php" method="POST">
          <div class="form-group">
            <label class="form-label">Email atau Username</label>
            <input
              type="text"
              name="username"
              class="form-control"
              placeholder="Masukkan email atau username"
              required
            />
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Masukkan password"
              required
            />
          </div>

          <button type="submit" class="btn-auth">Masuk</button>
        </form>

        <div class="auth-links">
          <a href="javascript:alert('Fitur reset password akan segera hadir!')">Lupa Password?</a>
          <p>Belum punya akun? <a href="daftar.php">Daftar sekarang</a></p>
        </div>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <h3>OMNIGAMES</h3>
        <p>
          Platform marketplace dan portal informasi game digital terpercaya di Indonesia.
        </p>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> OMNIGAMES Project. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>