<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog Game - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="index.php?route=katalog" style="color: #ffd700; font-weight: bold">Katalog Game</a>
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

    <div class="catalog-header">
      <h2>Semua Game</h2>
      <form action="index.php" method="GET" class="catalog-filter">
        <input type="hidden" name="route" value="katalog">
        <?php if (!empty($keyword_aktif)): ?>
            <input type="hidden" name="q" value="<?php echo htmlspecialchars($keyword_aktif); ?>">
        <?php endif; ?>
        <select name="kategori" class="filter-select" onchange="this.form.submit()">
          <option value="all" <?php echo (isset($kategori_aktif) && $kategori_aktif === 'all') ? 'selected' : ''; ?>>Semua Kategori</option>
          <option value="rpg" <?php echo (isset($kategori_aktif) && strtolower($kategori_aktif) === 'rpg') ? 'selected' : ''; ?>>RPG & Adventure</option>
          <option value="action" <?php echo (isset($kategori_aktif) && strtolower($kategori_aktif) === 'action') ? 'selected' : ''; ?>>Action & Sci-Fi</option>
          <option value="simulation" <?php echo (isset($kategori_aktif) && strtolower($kategori_aktif) === 'simulation') ? 'selected' : ''; ?>>Simulation</option>
          <option value="sports" <?php echo (isset($kategori_aktif) && strtolower($kategori_aktif) === 'sports') ? 'selected' : ''; ?>>Sports & Racing</option>
        </select>
        <select name="urut" class="filter-select" onchange="this.form.submit()">
          <option value="popular" <?php echo (isset($urut_aktif) && $urut_aktif === 'popular') ? 'selected' : ''; ?>>Paling Populer</option>
          <option value="new" <?php echo (isset($urut_aktif) && $urut_aktif === 'new') ? 'selected' : ''; ?>>Terbaru</option>
          <option value="price-low" <?php echo (isset($urut_aktif) && $urut_aktif === 'price-low') ? 'selected' : ''; ?>>Harga Terendah</option>
          <option value="price-high" <?php echo (isset($urut_aktif) && $urut_aktif === 'price-high') ? 'selected' : ''; ?>>Harga Tertinggi</option>
        </select>
      </form>
    </div>

    <main class="container">
      <div class="game-grid">
        <?php if (isset($result) && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="game-card">
              <img
                src="public/Image/<?php echo htmlspecialchars($row['gambar']); ?>"
                alt="<?php echo htmlspecialchars($row['judul']); ?>"
                class="game-img"
              />
              <div class="game-body">
                <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
                <p class="genre"><?php echo htmlspecialchars($row['genre']); ?></p>
                <p class="specs"><?php echo htmlspecialchars($row['spesifikasi']); ?></p>
                <div class="rating-price">
                  <span class="rating">⭐ <?php echo htmlspecialchars($row['rating']); ?></span>
                  <span class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                </div>
              </div>
              <div class="game-footer">
                <a href="index.php?route=detail&id=<?php echo $row['id']; ?>" class="btn-detail">Lihat Detail</a>
                <a href="index.php?route=marketplace&beli=<?php echo $row['id']; ?>" class="btn-buy">Beli Sekarang</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p id="empty-search-message" style="text-align: center; width: 100%; grid-column: 1 / -1; padding: 40px 0;">Belum ada game yang sesuai dengan filter atau pencarian.</p>
        <?php endif; ?>
      </div>

      <div class="pagination">
        <a href="index.php?route=katalog&page=1" class="page-btn active">1</a>
        <a href="#" class="page-btn">2</a>
        <a href="#" class="page-btn">3</a>
        <a href="#" class="page-btn">Selanjutnya &raquo;</a>
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
    <script src="public/js/search.js"></script>
  </body>
</html>