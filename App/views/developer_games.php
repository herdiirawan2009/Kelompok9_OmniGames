<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Game Saya - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php?route=developer_dashboard" style="color: #ffd700; font-weight: bold;">Dashboard Dev</a>
        <a href="index.php">Lihat Website</a>
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
        <h2>Game Saya</h2>
      </div>

      <div style="overflow-x:auto; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.03);">
          <thead>
            <tr>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Gambar</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Judul Game</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Genre</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($games && $games->num_rows > 0): ?>
              <?php while($row = $games->fetch_assoc()): ?>
              <tr>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                  <img src="public/Image/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" style="width: 120px; height: auto; border-radius: 8px;" />
                </td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['judul']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['genre']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="padding: 20px; text-align: center; color: #ccc;">Anda belum membeli game apapun.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <h3>OMNIGAMES</h3>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> OMNIGAMES Project. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>