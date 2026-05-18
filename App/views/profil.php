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
        <a href="index.php?route=profil" class="btn-register" style="background-color: transparent; color: #ffd700; border: 1px solid #ffd700; font-weight: bold;">Profil Saya</a>
        <a href="index.php?route=keluar" class="btn-login">Keluar</a>
      </div>
    </header>

    <main class="container">
      <div class="catalog-header" style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 2.5rem; color: #ffd700; margin-bottom: 10px;">Profil Pengguna</h2>
        <p style="color: #ccc; font-size: 1.1rem;">Informasi detail akun Anda yang terdaftar di OMNIGAMES.</p>
      </div>

      <section class="profile-section" style="display: flex; justify-content: center;">
        <div class="profile-card" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; padding: 40px; width: 100%; max-width: 600px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); backdrop-filter: blur(10px);">
          
          <div class="profile-header" style="text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 25px; margin-bottom: 30px;">
            <div style="width: 100px; height: 100px; background-color: #ffd700; color: #1a1a2e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: bold; margin: 0 auto 15px auto;">
              <?php echo strtoupper(substr($profil_nama, 0, 1)); ?>
            </div>
            <h3 style="font-size: 1.8rem; margin-bottom: 5px; color: #fff;"><?php echo htmlspecialchars($profil_nama); ?></h3>
            <span style="display: inline-block; background-color: <?php echo ($profil_role === 'admin') ? '#ff4d4d' : '#4CAF50'; ?>; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: bold; text-transform: uppercase;">
              <?php echo htmlspecialchars($profil_role); ?>
            </span>
          </div>

          <div class="profile-details" style="display: grid; gap: 20px;">
            
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

    <style>
      .btn-logout:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 77, 77, 0.4);
      }
    </style>
  </body>
</html>