<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Game - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES ADMIN</h1>
      </div>
      <nav class="navbar">
        <a href="index.php?route=admin_dashboard">Dashboard</a>
        <a href="index.php">Lihat Website</a>
      </nav>
      <div class="user-menu">
        <span style="color: #ffffff; margin-right: 15px;">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> (Admin)</span>
        <a href="index.php?route=keluar" class="btn-login">Keluar</a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Daftar Game</h2>
        <a href="index.php?route=admin_tambah_game" class="btn-register" style="background-color: #ffd700; color: #000;">Tambah Game Baru</a>
      </div>

      <div style="overflow-x:auto; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.03);">
          <thead>
            <tr>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Gambar</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Judul</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Harga</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                  <img src="public/Image/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" style="width: 120px; height: auto; border-radius: 8px;" />
                </td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['judul']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                  <a href="index.php?route=admin_edit_game&id=<?php echo intval($row['id']); ?>" class="btn-detail">Edit</a>
                  <a href="index.php?route=admin_hapus_game&id=<?php echo intval($row['id']); ?>" class="btn-buy" style="margin-left: 10px;">Hapus</a>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="padding: 20px; text-align: center; color: #ccc;">Belum ada data game.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
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
