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
      <div class="logo"><h1>OMNIGAMES ADMIN</h1></div>
      <nav class="navbar">
        <a href="index.php?route=admin_dashboard">Dashboard</a>
        <a href="index.php?route=admin_games">Daftar Game</a>
      </nav>
      <div class="user-menu">
        <span style="color:#fff;margin-right:10px;">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> (Admin)</span>
        <a href="index.php?route=profil" style="display:inline-block;">
          <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
        </a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2>Riwayat Transaksi</h2>
      </div>

      <?php
        $query = "SELECT t.id, t.total_bayar, t.metode_pembayaran, t.status_pembayaran, t.tanggal_transaksi,
                         u.nama_lengkap, u.email,
                         GROUP_CONCAT(g.judul SEPARATOR ', ') as judul_game
                  FROM transaksi t
                  JOIN users u ON t.user_id = u.id
                  LEFT JOIN detail_transaksi dt ON t.id = dt.transaksi_id
                  LEFT JOIN games g ON dt.game_id = g.id
                  GROUP BY t.id
                  ORDER BY t.tanggal_transaksi DESC";
        $result = $db->query($query);
      ?>

      <div style="margin-top:20px; overflow-x:auto;">
        <?php if ($result && $result->num_rows > 0): ?>
        <table style="width:100%;border-collapse:collapse;background:#1a1a2e;color:#fff;">
          <thead>
            <tr style="background:#ffd700;color:#000;">
              <th style="padding:10px;text-align:left;">#</th>
              <th style="padding:10px;text-align:left;">Pembeli</th>
              <th style="padding:10px;text-align:left;">Game</th>
              <th style="padding:10px;text-align:left;">Total</th>
              <th style="padding:10px;text-align:left;">Metode</th>
              <th style="padding:10px;text-align:left;">Status</th>
              <th style="padding:10px;text-align:left;">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr style="border-bottom:1px solid #333;">
              <td style="padding:10px;"><?php echo $row['id']; ?></td>
              <td style="padding:10px;"><?php echo htmlspecialchars($row['nama_lengkap']); ?><br><small style="color:#aaa;"><?php echo htmlspecialchars($row['email']); ?></small></td>
              <td style="padding:10px;"><?php echo htmlspecialchars($row['judul_game'] ?? '-'); ?></td>
              <td style="padding:10px;">Rp <?php echo number_format($row['total_bayar'],0,',','.'); ?></td>
              <td style="padding:10px;"><?php echo htmlspecialchars($row['metode_pembayaran']); ?></td>
              <td style="padding:10px;"><span style="color:#4caf50;"><?php echo htmlspecialchars($row['status_pembayaran']); ?></span></td>
              <td style="padding:10px;"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])); ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div style="text-align:center;padding:40px;color:#aaa;">Belum ada transaksi.</div>
        <?php endif; ?>
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