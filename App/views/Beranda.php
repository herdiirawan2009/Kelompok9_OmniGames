<?php
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo "Gagal terhubung ke database.";
    exit;
}

$queryPopuler = "SELECT * FROM games WHERE is_populer = 1 LIMIT 3";
$resultPopuler = $db->query($queryPopuler);

$queryTerbaru = "SELECT * FROM games ORDER BY tanggal_rilis DESC LIMIT 3";
$resultTerbaru = $db->query($queryTerbaru);
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OMNIGAMES - Platform Game Digital</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php" style="color: #ffd700; font-weight: bold">Beranda</a>
        <a href="katalog.php">Katalog Game</a>
        <a href="marketplace.php">Marketplace</a>
        <a href="bantuan.php">Bantuan</a>
      </nav>
      <div class="user-menu">
        <a href="masuk.php" class="btn-login">Masuk</a>
        <a href="daftar.php" class="btn-register">Daftar</a>
      </div>
    </header>

    <section class="banner">
      <h2>Satu Platform Untuk Semua Kebutuhan Gaming Anda</h2>
      <p>Temukan spesifikasi lengkap, baca ulasan jujur, dan beli game original dengan aman.</p>
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari judul game atau genre..." />
        <button id="searchButton" class="btn-search">Cari</button>
      </div>
    </section>

    <main class="container">
      <div id="empty-search-message" style="display: none; text-align: center; margin: 20px 0">
        <p>Game tidak ditemukan. Silakan cari dengan kata kunci lain.</p>
      </div>

      <div class="section-header">
        <h3>Rekomendasi Terpopuler</h3>
        <a href="katalog.php" class="view-all">Lihat Semua</a>
      </div>

      <div class="game-grid">
        <?php while($row = $resultPopuler->fetch_assoc()): ?>
        <div class="game-card">
          <img src="public/js/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>" class="game-img" />
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
            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-detail">Lihat Detail</a>
            <a href="marketplace.php?beli=<?php echo $row['id']; ?>" class="btn-buy">Beli Sekarang</a>
          </div>
        </div>
        <?php endwhile; ?>
      </div>

      <div class="section-header">
        <h3>Baru Dirilis</h3>
        <a href="katalog.php" class="view-all">Lihat Semua</a>
      </div>

      <div class="game-grid">
        <?php while($row = $resultTerbaru->fetch_assoc()): ?>
        <div class="game-card">
          <img src="public/js/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>" class="game-img" />
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
            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-detail">Lihat Detail</a>
            <a href="marketplace.php?beli=<?php echo $row['id']; ?>" class="btn-buy">Beli Sekarang</a>
          </div>
        </div>
        <?php endwhile; ?>
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