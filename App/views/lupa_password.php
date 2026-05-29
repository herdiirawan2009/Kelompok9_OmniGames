<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - OMNIGAMES</title>
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
          <a href="index.php?route=profil" style="display:inline-block;">
            <img src="public/Image/<?php echo !empty($_SESSION['foto_profil']) ? htmlspecialchars($_SESSION['foto_profil']) : 'default_avatar.png'; ?>" alt="Profil" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ffd700;" />
          </a>
        <?php else: ?>
          <a href="index.php?route=masuk" class="btn-login">Masuk</a>
          <a href="index.php?route=daftar" class="btn-register">Daftar</a>
        <?php endif; ?>
      </div>
    </header>

    <main class="container auth-container">
      <div class="auth-card">
        <h2>Lupa Password</h2>

        <?php if (isset($_SESSION['error_forgot'])): ?>
          <div style="color: #ff4d4d; background: rgba(255, 77, 77, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
            <?php
              echo $_SESSION['error_forgot'];
              unset($_SESSION['error_forgot']);
            ?>
          </div>
        <?php endif; ?>

        <form action="index.php?route=proses_lupa_password" method="POST">
          <div class="form-group">
            <label class="form-label">Email terdaftar</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email terdaftar" required />
          </div>

          <div class="form-group">
            <label class="form-label">Password baru</label>
            <div class="password-field">
              <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru" required />
              <button type="button" class="password-toggle" data-target="password">👁</button>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi password baru</label>
            <div class="password-field">
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Ulangi password baru" required />
              <button type="button" class="password-toggle" data-target="confirm_password">👁</button>
            </div>
          </div>

          <button type="submit" class="btn-auth">Reset Password</button>
        </form>

        <div class="auth-links">
          <p>Ingat password? <a href="index.php?route=masuk">Masuk di sini</a></p>
        </div>
      </div>
    </main>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.password-toggle').forEach(function(button) {
          button.addEventListener('click', function() {
            var target = document.getElementById(button.dataset.target);
            if (!target) return;
            if (target.type === 'password') {
              target.type = 'text';
            } else {
              target.type = 'password';
            }
          });
        });
      });
    </script>

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
