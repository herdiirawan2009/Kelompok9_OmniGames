<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!$game) {
    echo "<h1>Game tidak ditemukan.</h1>";
    echo "<a href='index.php?route=katalog'>Kembali ke Katalog</a>";
    exit;
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail <?php echo $game['judul']; ?> - OMNIGAMES</title>
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
            <a href="index.php?route=profil" style="display:inline-block;">
              <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
            </a>
        <?php else: ?>
          <a href="index.php?route=masuk" class="btn-login">Masuk</a>
          <a href="index.php?route=daftar" class="btn-register">Daftar</a>
        <?php endif; ?>
      </div>
    </header>

    <main class="container">
      <div class="detail-header">
        <img
          src="public/Image/<?php echo $game['gambar']; ?>"
          alt="<?php echo $game['judul']; ?>"
          class="detail-img"
        />
        <div class="detail-info">
          <h2><?php echo $game['judul']; ?></h2>
          <p class="detail-genre"><?php echo $game['genre']; ?></p>
          <div class="detail-rating">⭐ <?php echo $game['rating']; ?> / 5.0</div>
          <div class="detail-price">Rp <?php echo number_format($game['harga'], 0, ',', '.'); ?></div>
          <a href="index.php?route=marketplace&beli=<?php echo $game['id']; ?>" class="btn-buy-large">
            Tambahkan ke Keranjang
          </a>
        </div>
      </div>

      <div class="detail-content">
        <div class="detail-description">
          <h3>Tentang Game Ini</h3>
          <p><?php echo $game['deskripsi'] ? $game['deskripsi'] : "Belum ada deskripsi untuk game ini."; ?></p>
        </div>

        <div class="detail-specs">
          <h3>Spesifikasi Sistem</h3>
          <div class="specs-grid">
            <div class="specs-box">
              <h4>Minimum</h4>
              <p><?php echo nl2br($game['spesifikasi']); ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="review-section">
        <h3>Ulasan & Rating Pengguna</h3>

        <div class="review-form">
          <h4>Tulis Ulasan Kamu</h4>
          <form action="index.php?route=proses_ulasan" method="POST">
            <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
            <select name="rating_user" class="form-control">
              <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
              <option value="4">⭐⭐⭐⭐ (Bagus)</option>
              <option value="3">⭐⭐⭐ (Lumayan)</option>
              <option value="2">⭐⭐ (Buruk)</option>
              <option value="1">⭐ (Sangat Buruk)</option>
            </select>
            <textarea
              name="komentar"
              class="form-control"
              placeholder="Tuliskan pengalamanmu bermain game ini..."
              required
            ></textarea>
            <button type="submit" class="btn-submit">Kirim Ulasan</button>
          </form>
        </div>

        <div class="review-list">
          <?php if ($resultUlasan && $resultUlasan->num_rows > 0): ?>
            <?php while($ulasan = $resultUlasan->fetch_assoc()): ?>
              <div class="review-card">
                <div class="review-header">
                  <span class="review-user"><?php echo $ulasan['nama_user']; ?></span>
                  <span class="review-stars">
                    <?php echo str_repeat("⭐", $ulasan['rating_user']); ?>
                  </span>
                </div>
                <p class="review-text"><?php echo $ulasan['komentar']; ?></p>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>Belum ada ulasan untuk game ini.</p>
          <?php endif; ?>
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