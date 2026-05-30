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
      <div>
        <h2>Semua Game</h2>
        <p style="color:#ccc; margin-top:8px;">Pilih kategori atau urutkan game sesuai kebutuhan.</p>
      </div>
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

    <?php
      $homeGames = [];
      $homeIds = [];
      if (isset($resultPopuler) && $resultPopuler->num_rows > 0) {
        while ($row = $resultPopuler->fetch_assoc()) {
          if (!isset($homeIds[$row['id']])) {
            $homeIds[$row['id']] = true;
            $homeGames[] = $row;
          }
        }
      }
      if (isset($resultTerbaru) && $resultTerbaru->num_rows > 0) {
        while ($row = $resultTerbaru->fetch_assoc()) {
          if (!isset($homeIds[$row['id']])) {
            $homeIds[$row['id']] = true;
            $homeGames[] = $row;
          }
        }
      }
    ?>

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
          <p id="empty-search-message" style="text-align: center; width: 100%; grid-column: 1 / -1; padding: 20px 0;">Belum ada game yang sesuai dengan filter atau pencarian. Silakan ubah pilihan filter atau lihat rekomendasi Beranda di atas.</p>
        <?php endif; ?>
      </div>
      <?php
        $total_pages = isset($total_pages) ? intval($total_pages) : 1;
        $current_page = isset($current_page) ? intval($current_page) : 1;
        $maxButtons = max(3, $total_pages); // always show at least 3 buttons
      ?>
      <div class="pagination">
        <?php
          $baseScript = isset($_SERVER['SCRIPT_NAME']) ? basename($_SERVER['SCRIPT_NAME']) : 'index.php';
          // Prev
          if ($current_page > 1) {
            $p = $current_page - 1;
            $params = ['route' => 'katalog', 'page' => $p];
            if (isset($kategori_aktif) && $kategori_aktif !== '') { $params['kategori'] = $kategori_aktif; }
            if (isset($urut_aktif) && $urut_aktif !== '') { $params['urut'] = $urut_aktif; }
            if (isset($keyword_aktif) && $keyword_aktif !== '') { $params['q'] = $keyword_aktif; }
            echo '<a href="' . $baseScript . '?' . http_build_query($params) . '" class="page-btn" onclick="window.location.href=this.href;">&laquo; Prev</a>';
          } else {
            echo '<span class="page-btn disabled">&laquo; Prev</span>';
          }

          // Page numbers (show at least 1..3)
          for ($i = 1; $i <= $maxButtons; $i++) {
            $cls = ($i === $current_page) ? 'page-btn active' : 'page-btn';
              if ($i <= $total_pages) {
              $params = ['route' => 'katalog', 'page' => $i];
              if (isset($kategori_aktif) && $kategori_aktif !== '') { $params['kategori'] = $kategori_aktif; }
              if (isset($urut_aktif) && $urut_aktif !== '') { $params['urut'] = $urut_aktif; }
              if (isset($keyword_aktif) && $keyword_aktif !== '') { $params['q'] = $keyword_aktif; }
              echo '<a href="' . $baseScript . '?' . http_build_query($params) . '" class="' . $cls . '" onclick="window.location.href=this.href;">' . $i . '</a>';
            } else {
              // disabled placeholder
              echo '<span class="page-btn disabled">' . $i . '</span>';
            }
          }

          // Next
          if ($current_page < $total_pages) {
            $p = $current_page + 1;
            $params = ['route' => 'katalog', 'page' => $p];
            if (isset($kategori_aktif) && $kategori_aktif !== '') { $params['kategori'] = $kategori_aktif; }
            if (isset($urut_aktif) && $urut_aktif !== '') { $params['urut'] = $urut_aktif; }
            if (isset($keyword_aktif) && $keyword_aktif !== '') { $params['q'] = $keyword_aktif; }
            echo '<a href="' . $baseScript . '?' . http_build_query($params) . '" class="page-btn" onclick="window.location.href=this.href;">Selanjutnya &raquo;</a>';
          } else {
            echo '<span class="page-btn disabled">Selanjutnya &raquo;</span>';
          }
        ?>
        </div>
      
      
    </main>

    <div class="section-header">
      <h3>Semua Game</h3>
    </div>
    <div class="game-grid">
      <?php if (!empty($homeGames)): ?>
        <?php foreach ($homeGames as $row): ?>
          <div class="game-card">
            <img src="public/Image/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="game-img" />
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
        <?php endforeach; ?>
      <?php else: ?>
        <p style="width:100%; text-align:center; color:#ccc;">Tidak ada game Beranda untuk ditampilkan.</p>
      <?php endif; ?>
    </div>

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
    <script>
      // Debug logger for pagination clicks (non-blocking)
      document.addEventListener('DOMContentLoaded', function() {
        var links = document.querySelectorAll('.pagination a.page-btn');
        links.forEach(function(a, idx) {
          a.addEventListener('click', function(e) {
            console.log('[pagination] click', idx, a.getAttribute('href'));
            // allow default navigation to proceed
          });
        });
      });
    </script>
  </body>
</html>