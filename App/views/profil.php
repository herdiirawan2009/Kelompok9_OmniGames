<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?route=masuk');
    exit;
}

$username = $_SESSION['username'] ?? '';
$nama = $_SESSION['nama_lengkap'] ?? '';
$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? '';
$foto = isset($foto_profil) && $foto_profil !== '' ? $foto_profil : (!empty($_SESSION['foto_profil']) ? $_SESSION['foto_profil'] : 'default_avatar.png');
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
    <style>
      body { background: #0f0f10; color: #eaeaea; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
      .wrap { max-width:420px; margin:40px auto; padding:20px 16px; }
      .photo { display:flex; flex-direction:column; align-items:center; gap:10px; }
      .photo img { width:160px; height:160px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,215,0,0.9); }
      .role { font-size:0.95rem; color:#cfcfcf; letter-spacing:0.2px; }
      .upload-label { display:inline-block; padding:6px 10px; font-size:0.85rem; background:transparent; color:#ffd700; border:1px solid rgba(255,215,0,0.12); border-radius:6px; cursor:pointer; }
      .upload-input { display:none; }
      hr.main { border:none; height:1px; background:linear-gradient(90deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02)); margin:18px 0; }
      .info { display:flex; flex-direction:column; gap:12px; }
      .info-row { padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
      .info-label { font-size:0.75rem; color:#9a9a9a; margin-bottom:6px; }
      .info-value { font-size:1.02rem; color:#ffffff; }
      .dashboard-link { display:block; margin:18px auto 6px; text-align:center; color:#ffd700; padding:8px 14px; border-radius:999px; text-decoration:none; font-weight:600; max-width:260px; border:1px solid rgba(255,215,0,0.12); background:transparent; }
      .dashboard-divider { height:1px; background:rgba(255,255,255,0.04); margin:8px 0 0; width:100%; }
      .logout { display:block; margin:28px auto 0; text-align:center; background: linear-gradient(180deg,#ff5b5b,#d32f2f); color:#fff; padding:10px 18px; border-radius:999px; text-decoration:none; width:100%; max-width:260px; }
      @media (max-width:480px){ .wrap{margin:20px 12px} .photo img{width:130px;height:130px} }
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="photo">
        <img src="public/Image/<?php echo htmlspecialchars($foto); ?>" alt="Foto Profil" />
        <div class="role"><?php echo htmlspecialchars($role ?: 'User'); ?></div>
        <form action="index.php?route=upload_foto" method="POST" enctype="multipart/form-data">
          <input id="fileFoto" class="upload-input" type="file" name="foto" accept="image/*" onchange="this.form.submit()" />
          <label for="fileFoto" class="upload-label">Ganti Foto</label>
        </form>
      </div>

      <hr class="main" />

      <div class="info">
        <div class="info-row">
          <div class="info-label">Username</div>
          <div class="info-value"><?php echo htmlspecialchars($username); ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">Nama Lengkap</div>
          <div class="info-value"><?php echo htmlspecialchars($nama); ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">Alamat Email</div>
          <div class="info-value"><?php echo htmlspecialchars($email); ?></div>
        </div>
      </div>

      <a href="index.php?route=developer_dashboard" class="dashboard-link">Dashboard Developer</a>
      <div class="dashboard-divider"></div>

      <a href="index.php?route=keluar" class="logout">Keluar dari Akun</a>
    </div>
  </body>
</html>