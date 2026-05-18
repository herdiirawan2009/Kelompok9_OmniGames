<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesan Masuk - OMNIGAMES</title>
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
        <span style="color: #ffffff; margin-right: 15px;">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> (Admin)</span>
        <a href="index.php?route=keluar" class="btn-login">Keluar</a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Pesan Masuk</h2>
      </div>

      <div style="overflow-x:auto; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.03);">
          <thead>
            <tr>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Nama</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Email</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Kategori</th>
              <th style="padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">Pesan</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['nama']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['email']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);"><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="padding: 20px; text-align: center; color: #ccc;">Belum ada pesan masuk.</td>
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
