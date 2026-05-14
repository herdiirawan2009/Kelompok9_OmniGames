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
        <a href="index.php?route=masuk" class="btn-login">Masuk</a>
        <a href="index.php?route=daftar" class="btn-register">Daftar</a>
      </div>
    </header>

    <div class="catalog-header">
      <h2>Semua Game</h2>
      <div class="catalog-filter">
        <select class="filter-select">
          <option value="all">Semua Kategori</option>
          <option value="rpg">RPG & Adventure</option>
          <option value="action">Action & Sci-Fi</option>
          <option value="simulation">Simulation</option>
          <option value="sports">Sports & Racing</option>
        </select>
        <select class="filter-select">
          <option value="popular">Paling Populer</option>
          <option value="new">Terbaru</option>
          <option value="price-low">Harga Terendah</option>
          <option value="price-high">Harga Tertinggi</option>
        </select>
      </div>
    </div>

    <main class="container">
      <div class="game-grid">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="game-card">
              <img
                src="public/Image/<?php echo $row['gambar']; ?>"
                alt="<?php echo $row['judul']; ?>"
                class="game-img"
              />
              <div class="game-body">
                <h4><?php echo $row['judul']; ?></h4>
                <p class="genre"><?php echo $row['genre']; ?></p>
                <p class="specs"><?php echo $row['spesifikasi']; ?></p>
                <div class="rating-price">
                  <span class="rating">⭐ <?php echo $row['rating']; ?></span>
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
          <p>Belum ada game yang tersedia di katalog.</p>
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
  </body>
</html>