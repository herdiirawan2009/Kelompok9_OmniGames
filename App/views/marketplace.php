<?php
session_start(); 
$database = new Database();
$db = $database->getConnection();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['beli'])) {
    $id_beli = intval($_GET['beli']);
    if (!in_array($id_beli, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id_beli;
    }
    header("Location: marketplace.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    if (($key = array_search($id_hapus, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    }
    header("Location: marketplace.php");
    exit;
}

$cart_items = [];
$total_harga = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']); 
    $query = "SELECT * FROM games WHERE id IN ($ids)";
    $result = $db->query($query);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
            $total_harga += $row['harga']; // Hitung subtotal
        }
    }
}

$pajak = $total_harga * 0.11; // Pajak 11%
$total_bayar = $total_harga + $pajak;
$jumlah_game = count($cart_items);
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marketplace - OMNIGAMES</title>
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <h1>OMNIGAMES</h1>
      </div>
      <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="katalog.php">Katalog Game</a>
        <a href="marketplace.php" style="color: #ffd700; font-weight: bold">Marketplace</a>
        <a href="bantuan.php">Bantuan</a>
      </nav>
      <div class="user-menu">
        <a href="masuk.php" class="btn-login">Masuk</a>
        <a href="daftar.php" class="btn-register">Daftar</a>
      </div>
    </header>

    <div class="catalog-header">
      <h2>Keranjang Belanja</h2>
    </div>

    <main class="container marketplace-layout">
      <div class="cart-section">
        <?php if ($jumlah_game > 0): ?>
          <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
              <img
                src="public/js/<?php echo $item['gambar']; ?>"
                alt="<?php echo $item['judul']; ?>"
                class="cart-img"
              />
              <div class="cart-info">
                <h4><?php echo $item['judul']; ?></h4>
                <p class="cart-category"><?php echo $item['genre']; ?></p>
              </div>
              <div class="cart-price">
                <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                <a href="marketplace.php?hapus=<?php echo $item['id']; ?>" class="btn-remove">Hapus</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div style="text-align: center; padding: 40px 0;">
            <p>Keranjang belanja kamu masih kosong.</p>
            <a href="katalog.php" style="color: #ffd700; text-decoration: none; margin-top: 10px; display: inline-block;">Mulai Belanja</a>
          </div>
        <?php endif; ?>
      </div>

      <div class="checkout-section">
        <h3>Ringkasan Pesanan</h3>

        <div class="summary-row">
          <span>Total Harga (<?php echo $jumlah_game; ?> Game)</span>
          <span>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></span>
        </div>
        <div class="summary-row">
          <span>Pajak (11%)</span>
          <span>Rp <?php echo number_format($pajak, 0, ',', '.'); ?></span>
        </div>

        <div class="summary-total">
          <span>Total Bayar</span>
          <span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
        </div>

        <form action="proses_pembayaran.php" method="POST">
          <div class="payment-method">
            <p>Metode Pembayaran:</p>
            <select name="metode_pembayaran" class="payment-select" required>
              <option value="transfer">Transfer Bank (BCA/Mandiri)</option>
              <option value="ewallet">E-Wallet (GoPay/OVO/Dana)</option>
              <option value="qris">Scan QRIS</option>
            </select>
          </div>

          <input type="hidden" name="total_bayar" value="<?php echo $total_bayar; ?>">
          
          <?php if ($jumlah_game > 0): ?>
            <button type="submit" class="btn-checkout" style="width: 100%; border: none; cursor: pointer;">Bayar Sekarang</button>
          <?php else: ?>
            <button type="button" class="btn-checkout" style="width: 100%; border: none; opacity: 0.5; cursor: not-allowed;" disabled>Keranjang Kosong</button>
          <?php endif; ?>
        </form>
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