<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?route=masuk');
    exit;
}

$profil_nama = $_SESSION['nama_lengkap'] ?? '';
$profil_username = $_SESSION['username'] ?? '';
$profil_email = $_SESSION['email'] ?? '';
$profil_role = $_SESSION['role'] ?? '';
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - OMNIGAMES</title>
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
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <a href="index.php?route=admin_dashboard" class="btn-register" style="background-color: #ffd700; color: #000; font-weight: bold; margin-right: 10px;">Panel Admin</a>
        <?php endif; ?>
        <span style="color: #ffffff; margin-right: 15px;">Halo, <?php echo htmlspecialchars($profil_nama); ?></span>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header" style="text-align: center; margin-bottom: 20px;">
        <h2>Informasi Akun</h2>
        <p>Kelola data profil dan akses fitur penjual/developer Anda di sini.</p>
      </div>

      <section class="auth-container" style="margin-top: 20px; max-width: 800px;">
        <div class="auth-card" style="padding: 40px; border-top: 5px solid #ffd700;">
          
          <div class="profile-details" style="display: grid; gap: 20px;">
            <div class="profile-field" style="background: rgba(0,0,0,0.2); padding: 15px 20px; border-radius: 8px; border-left: 4px solid #ffd700;">
              <span style="display: block; font-size: 0.9rem; color: #aaa; margin-bottom: 5px;">Nama Lengkap</span>
              <strong style="font-size: 1.1rem; color: #fff;"><?php echo htmlspecialchars($profil_nama); ?></strong>
            </div>

            <div class="profile-field" style="background: rgba(0,0,0,0.2); padding: 15px 20px; border-radius: 8px; border-left: 4px solid #ffd700;">
              <span style="display: block; font-size: 0.9rem; color: #aaa; margin-bottom: 5px;">Username</span>
              <strong style="font-size: 1.1rem; color: #fff;"><?php echo htmlspecialchars($profil_username); ?></strong>
            </div>

            <div class="profile-field" style="background: rgba(0,0,0,0.2); padding: 15px 20px; border-radius: 8px; border-left: 4px solid #ffd700;">
              <span style="display: block; font-size: 0.9rem; color: #aaa; margin-bottom: 5px;">Alamat Email</span>
              <strong style="font-size: 1.1rem; color: #fff;"><?php echo htmlspecialchars($profil_email); ?></strong>
            </div>
          </div>

          <div class="profile-actions" style="margin-top: 40px; text-align: center;">
            <a href="index.php?route=developer_dashboard" class="btn-auth" style="display: inline-block; background: #ffd700; color: #000; padding: 12px 30px; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 1.1rem; margin-right: 15px; margin-bottom: 10px; transition: 0.2s;">
              Dashboard Developer Saya
            </a>
            <a href="index.php?route=keluar" class="btn-auth btn-logout" style="display: inline-block; background: linear-gradient(135deg, #ff4d4d, #d32f2f); color: white; padding: 12px 30px; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 1.1rem; transition: transform 0.2s, box-shadow 0.2s; border: none; cursor: pointer;">
              Keluar dari Akun
            </a>
          </div>
        </div>
      </section>
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
