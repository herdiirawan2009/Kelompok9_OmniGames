<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Transaksi - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES ADMIN</h1>
      </div>
      <nav class="navbar">
        <a href="index.php?route=admin_dashboard">Dashboard</a>
        <a href="index.php?route=admin_games">Daftar Game</a>
      </nav>
      <div class="user-menu">
        <span style="color: #ffffff; margin-right: 10px;">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> (Admin)</span>
        <a href="index.php?route=profil" style="display:inline-block;">
          <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
        </a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Riwayat Transaksi</h2>
      </div>

      <div class="auth-container" style="margin-top: 20px; max-width: 900px;">
        <div class="auth-card" style="padding: 30px; text-align: center;">
          <p style="color: #ccc;">Belum ada riwayat transaksi yang tersedia untuk ditampilkan.</p>
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
