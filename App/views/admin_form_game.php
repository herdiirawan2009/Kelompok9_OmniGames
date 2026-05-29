<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($game) ? 'Edit Game' : 'Tambah Game'; ?> - OMNIGAMES</title>
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
        <span style="color: #ffffff; margin-right: 10px;">Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> (Admin)</span>
        <a href="index.php?route=profil" style="display:inline-block;">
          <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
        </a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header">
        <h2><?php echo isset($game) ? 'Edit Game' : 'Tambah Game'; ?></h2>
      </div>

      <div class="auth-container" style="margin-top: 20px; max-width: 900px;">
        <div class="auth-card" style="padding: 30px;">
          <form action="index.php?route=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
            <?php if (isset($game)): ?>
              <input type="hidden" name="id" value="<?php echo intval($game['id']); ?>" />
            <?php endif; ?>

            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" value="<?php echo isset($game['judul']) ? htmlspecialchars($game['judul']) : ''; ?>" required />

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" value="<?php echo isset($game['genre']) ? htmlspecialchars($game['genre']) : ''; ?>" required />

            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" value="<?php echo isset($game['harga']) ? intval($game['harga']) : ''; ?>" required />

            <label for="rating">Rating</label>
            <input type="number" step="0.1" max="10" min="0" id="rating" name="rating" value="<?php echo isset($game['rating']) ? htmlspecialchars($game['rating']) : ''; ?>" required />

            <label for="spesifikasi">Spesifikasi</label>
            <textarea id="spesifikasi" name="spesifikasi" rows="4" required><?php echo isset($game['spesifikasi']) ? htmlspecialchars($game['spesifikasi']) : ''; ?></textarea>

            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo isset($game['deskripsi']) ? htmlspecialchars($game['deskripsi']) : ''; ?></textarea>

            <label for="gambar">Gambar</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" <?php echo isset($game) ? '' : 'required'; ?> />
            <?php if (isset($game) && $game['gambar'] !== ''): ?>
              <p style="margin-top: 10px; color: #ccc;">Gambar saat ini:</p>
              <img src="public/Image/<?php echo htmlspecialchars($game['gambar']); ?>" alt="<?php echo htmlspecialchars($game['judul']); ?>" style="width: 180px; height: auto; border-radius: 8px; margin-bottom: 20px;" />
            <?php endif; ?>

            <button type="submit" class="btn-register" style="background-color: #ffd700; color: #000; margin-top: 10px;">Simpan</button>
          </form>
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
