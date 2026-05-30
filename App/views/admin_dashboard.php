<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES ADMIN</h1>
      </div>
      <nav class="navbar">
        <a href="index.php?route=admin_dashboard" style="color: #ffd700; font-weight: bold">Dashboard</a>
        <a href="index.php">Lihat Website</a>
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
        <h2>Panel Kendali Administrator</h2>
        <p>Selamat datang di halaman khusus admin OMNIGAMES.</p>
      </div>

      <div class="auth-container" style="margin-top: 20px; max-width: 1200px;">
        <div class="auth-card" style="max-width: 100%;">
          <h3>Menu Manajemen</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <h4>Kelola Game</h4>
              <p style="font-size: 14px; color: #aaa; margin: 10px 0;">Tambah, ubah, atau hapus katalog produk game digital.</p>
              <a href="index.php?route=admin_games" style="color: #ffd700; text-decoration: none; font-weight: bold; font-size: 14px;">Buka Manajemen Game &raquo;</a>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <h4>Pesan Pengguna</h4>
              <p style="font-size: 14px; color: #aaa; margin: 10px 0;">Lihat pesan dan kendala yang dikirim via pusat bantuan.</p>
              <a href="index.php?route=admin_pesan" style="color: #ffd700; text-decoration: none; font-weight: bold; font-size: 14px;">Lihat Kotak Masuk &raquo;</a>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <h4>Riwayat Transaksi</h4>
              <p style="font-size: 14px; color: #aaa; margin: 10px 0;">Pantau seluruh data pembelian dan pembayaran masuk.</p>
              <a href="index.php?route=admin_transaksi" style="color: #ffd700; text-decoration: none; font-weight: bold; font-size: 14px;">Lihat Transaksi &raquo;</a>
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