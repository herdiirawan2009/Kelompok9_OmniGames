<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Developer - OMNIGAMES</title>
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
        <a href="index.php?route=profil">Kembali ke Profil</a>
      </nav>
      <div class="user-menu">
        <span style="color: #ffffff; margin-right: 10px;">Developer: <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></span>
        <a href="index.php?route=profil" style="display:inline-block;">
          <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
        </a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Dashboard Developer</h2>
        <p>Kelola game yang Anda unggah dan pantau produk jualan Anda.</p>
      </div>

      <div class="auth-container" style="margin-top: 20px; max-width: 1200px;">
        <div class="auth-card" style="max-width: 100%;">
          <h3>Menu Manajemen Game Anda</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <h4>Game Saya</h4>
              <p style="font-size: 14px; color: #aaa; margin: 10px 0;">Lihat, edit, dan hapus game yang sudah Anda publikasikan di marketplace.</p>
              <a href="index.php?route=developer_games" style="color: #ffd700; text-decoration: none; font-weight: bold; font-size: 14px;">Kelola Game &raquo;</a>
            </div>
            
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <h4>Unggah Game Baru</h4>
              <p style="font-size: 14px; color: #aaa; margin: 10px 0;">Jual dan bagikan kreasi game buatan Anda kepada komunitas.</p>
              <a href="index.php?route=developer_tambah_game" style="color: #ffd700; text-decoration: none; font-weight: bold; font-size: 14px;">Tambah Game &raquo;</a>
            </div>

          </div>
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