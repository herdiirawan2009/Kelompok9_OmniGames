<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($game) ? 'Edit Game' : 'Unggah Game Baru'; ?> - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php?route=developer_dashboard">Dashboard Dev</a>
        <a href="index.php?route=developer_games">Daftar Game Saya</a>
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
        <h2><?php echo isset($game) ? 'Edit Game' : 'Unggah Game Baru'; ?></h2>
      </div>

      <div class="auth-container" style="margin-top: 20px; max-width: 900px;">
        <div class="auth-card" style="padding: 30px;">
          <form action="index.php?route=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
            
            <label for="judul">Judul Game</label>
            <input type="text" id="judul" name="judul" class="form-control" value="<?php echo isset($game['judul']) ? htmlspecialchars($game['judul']) : ''; ?>" required />

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" class="form-control" placeholder="Contoh: Action, RPG, Simulasi" value="<?php echo isset($game['genre']) ? htmlspecialchars($game['genre']) : ''; ?>" required />

            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" class="form-control" value="<?php echo isset($game['harga']) ? htmlspecialchars($game['harga']) : '0'; ?>" required />

            <label for="spesifikasi">Spesifikasi Minimum (OS, RAM, dsb)</label>
            <textarea id="spesifikasi" name="spesifikasi" class="form-control" rows="4" required><?php echo isset($game['spesifikasi']) ? htmlspecialchars($game['spesifikasi']) : ''; ?></textarea>

            <label for="deskripsi">Deskripsi Singkat</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required><?php echo isset($game['deskripsi']) ? htmlspecialchars($game['deskripsi']) : ''; ?></textarea>

            <label for="gambar">Gambar Cover (Wajib untuk game baru)</label>
            <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" <?php echo isset($game) ? '' : 'required'; ?> />
            
            <?php if (isset($game) && $game['gambar'] !== ''): ?>
              <p style="margin-top: 10px; color: #ccc;">Gambar saat ini:</p>
              <img src="public/Image/<?php echo htmlspecialchars($game['gambar']); ?>" alt="<?php echo htmlspecialchars($game['judul']); ?>" style="width: 180px; height: auto; border-radius: 8px; margin-bottom: 20px;" />
            <?php endif; ?>

            <button type="submit" class="btn-register" style="background-color: #ffd700; color: #000; margin-top: 20px; width: 100%;">
              <?php echo isset($game) ? 'Simpan Perubahan' : 'Unggah Game Sekarang'; ?>
            </button>
          </form>
        </div>
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