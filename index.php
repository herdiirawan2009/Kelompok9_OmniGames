<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $waktu_timeout = 300;
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $waktu_timeout) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['error_login'] = "Sesi Anda telah berakhir karena tidak ada aktivitas selama 5 menit. Silakan masuk kembali.";
        header("Location: index.php?route=masuk");
        exit;
    }
    $_SESSION['last_activity'] = time();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__); 
define('VIEWS_PATH', BASE_PATH . '/App/views/'); 
define('MODELS_PATH', BASE_PATH . '/App/models/'); 

require_once MODELS_PATH . 'Database.php';
require_once MODELS_PATH . 'Game_model.php';
require_once MODELS_PATH . 'Bantuan_model.php';

$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$projectFolder = '/' . basename(BASE_PATH); 

$route = str_replace($projectFolder, '', $requestUri); 
$route = str_replace('//', '/', $route); 
$route = rtrim($route, '/'); 

if (isset($_GET['route']) && trim($_GET['route']) !== '') {
    $route = '/' . trim($_GET['route'], '/');
}

if (empty($route)) { $route = '/'; }

if (
    $route !== '/' && 
    $route !== '/index.php' && 
    file_exists(BASE_PATH . $route) && 
    is_file(BASE_PATH . $route)
) {
    require_once BASE_PATH . $route;
    exit;
}

if (!function_exists('view')) {
    function view($path, $data = []) {
        extract($data); 
        $filePath = VIEWS_PATH . $path;

        if (file_exists($filePath)) {
            require $filePath;
        } else {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "File tampilan tidak ditemukan di: " . htmlspecialchars($filePath);
        }
    }
}

$database = new Database();
$db = $database->getConnection();
$gameModel = new Game_model($db);
$bantuanModel = new Bantuan_model($db);

switch ($route) {
    case '/':
    case '/index.php':
    case '':
        $resultPopuler = $gameModel->getPopuler();
        $resultTerbaru = $gameModel->getTerbaru();
        view('Beranda.php', [
            'resultPopuler' => $resultPopuler, 
            'resultTerbaru' => $resultTerbaru
        ]); 
        break;
    case '/detail':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $game = $gameModel->getGameById($id);
        $resultUlasan = $gameModel->getUlasanByGameId($id);
        view('detail.php', [
            'game' => $game, 
            'resultUlasan' => $resultUlasan
        ]);
        break;
    case '/proses_ulasan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $game_id = isset($_POST['game_id']) ? intval($_POST['game_id']) : 0;
            if (!isset($_SESSION['user_id'])) {
                echo "<script>alert('Silakan masuk ke akun terlebih dahulu untuk memberikan ulasan'); window.location.href='index.php?route=detail&id={$game_id}';</script>";
                exit;
            }
            $nama_user = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Pengguna';
            $rating = isset($_POST['rating_user']) ? intval($_POST['rating_user']) : 0;
            $komentar = isset($_POST['komentar']) ? $_POST['komentar'] : '';
            if ($gameModel->tambahUlasan($game_id, $nama_user, $rating, $komentar)) {
                echo "<script>window.location.href='index.php?route=detail&id={$game_id}';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ulasan'); window.location.href='index.php?route=detail&id={$game_id}';</script>";
            }
        }
        break;
    case '/katalog':
        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';
        $urut = isset($_GET['urut']) ? $_GET['urut'] : 'popular';
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';
        
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = 4;

        // adjust perPage down until we have at least 3 pages (if database has enough items)
        $paged = $gameModel->getGamesPaged($kategori, $urut, $keyword, $page, $perPage);
        $total_pages = $paged['total_pages'];
        while ($total_pages < 3 && $perPage > 1) {
            $perPage = max(1, (int) floor($perPage / 2));
            $paged = $gameModel->getGamesPaged($kategori, $urut, $keyword, $page, $perPage);
            $total_pages = $paged['total_pages'];
        }

        // ensure current page is within bounds
        if ($page > $total_pages) { $page = $total_pages; $paged = $gameModel->getGamesPaged($kategori, $urut, $keyword, $page, $perPage); $total_pages = $paged['total_pages']; }

        $result = $paged['result'];
        $resultPopuler = $gameModel->getPopulerAll();
        $resultTerbaru = $gameModel->getTerbaruAll();

        view('katalog.php', [
            'result' => $result,
            'kategori_aktif' => $kategori,
            'urut_aktif' => $urut,
            'keyword_aktif' => $keyword,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'resultPopuler' => $resultPopuler,
            'resultTerbaru' => $resultTerbaru,
        ]);
        break;
    case '/marketplace':
        view('marketplace.php', ['db' => $db]);
        break;
    case '/proses_checkout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?route=masuk');
                exit;
            }
            $user_id = intval($_SESSION['user_id']);
            $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $db->real_escape_string($_POST['metode_pembayaran']) : '';
            $total_harga = 0;
            if (!empty($_SESSION['cart'])) {
                $ids = implode(',', array_map('intval', $_SESSION['cart']));
                $query = "SELECT harga, id FROM games WHERE id IN ($ids)";
                $result = $db->query($query);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $total_harga += intval($row['harga']);
                    }
                }
            }
            $pajak = round($total_harga * 0.11);
            $total_bayar = $total_harga + $pajak;
            $status_pembayaran = 'Lunas';
            $stmt = $db->prepare("INSERT INTO transaksi (user_id, total_bayar, metode_pembayaran, status_pembayaran, tanggal_transaksi) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt) {
                $stmt->bind_param('iiss', $user_id, $total_bayar, $metode_pembayaran, $status_pembayaran);
                if ($stmt->execute()) {
                    $transaksi_id = $db->insert_id;
                    if (!empty($_SESSION['cart'])) {
                        $detail_stmt = $db->prepare("INSERT INTO detail_transaksi (transaksi_id, game_id) VALUES (?, ?)");
                        if ($detail_stmt) {
                            foreach ($_SESSION['cart'] as $game_id) {
                                $game_id = intval($game_id);
                                $detail_stmt->bind_param('ii', $transaksi_id, $game_id);
                                $detail_stmt->execute();
                            }
                        }
                    }
                    $_SESSION['cart'] = array();
                    echo "<script>alert('Pembayaran berhasil diproses! Terima kasih telah berbelanja.'); window.location.href='index.php?route=marketplace&t=' + Date.now();</script>";
                    exit;
                }
            }
            echo "<script>alert('Gagal memproses pembayaran'); window.location.href='index.php?route=marketplace';</script>";
            exit;
        }
        break;
    case '/bantuan':
        view('bantuan.php', ['db' => $db]);
        break;
    case '/masuk':
        view('masuk.php');
        break;
    case '/daftar':
        view('daftar.php');
        break;
    case '/profil':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=masuk");
            exit;
        }
        view('profil.php', ['foto_profil' => isset($_SESSION['foto_profil']) ? $_SESSION['foto_profil'] : '']);
        break;
    case '/upload_foto':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?route=masuk');
                exit;
            }

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/Image/';
                $tmpName = $_FILES['foto']['tmp_name'];
                $originalName = basename($_FILES['foto']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif','webp'];
                $extLower = strtolower($ext);
                if (!in_array($extLower, $allowed)) {
                    header('Location: index.php?route=profil');
                    exit;
                }
                $newName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $extLower;
                $targetPath = $uploadDir . $newName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $userId = intval($_SESSION['user_id']);
                    $stmt = $db->prepare("UPDATE users SET foto_profil = ? WHERE id = ?");
                    if ($stmt) {
                        $stmt->bind_param('si', $newName, $userId);
                        $stmt->execute();
                    }
                    $_SESSION['foto_profil'] = $newName;
                }
            }
            header('Location: index.php?route=profil');
            exit;
        }
        break;
    case '/admin_dashboard':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        view('admin_dashboard.php');
        break;
    case '/admin_games':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        $result = $gameModel->getAllGames();
        view('admin_games.php', ['result' => $result]);
        break;
    case '/admin_tambah_game':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        view('admin_form_game.php', ['action' => 'proses_tambah_game']);
        break;
    case '/admin_edit_game':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $game = $gameModel->getGameById($id);
        view('admin_form_game.php', ['action' => 'proses_edit_game', 'game' => $game]);
        break;
    case '/proses_tambah_game':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($gameModel->tambahGame($_POST, $_FILES['gambar'])) {
                echo "<script>alert('Game berhasil ditambahkan'); window.location.href='index.php?route=admin_games';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan game'); window.location.href='index.php?route=admin_tambah_game';</script>";
            }
        }
        break;
    case '/proses_edit_game':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($gameModel->editGame($id, $_POST, $_FILES['gambar'])) {
                echo "<script>alert('Game berhasil diubah'); window.location.href='index.php?route=admin_games';</script>";
            } else {
                echo "<script>alert('Gagal mengubah game'); window.location.href='index.php?route=admin_edit_game&id={$id}';</script>";
            }
        }
        break;
    case '/admin_hapus_game':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($gameModel->hapusGame($id)) {
            echo "<script>alert('Game berhasil dihapus'); window.location.href='index.php?route=admin_games';</script>";
        } else {
            echo "<script>alert('Gagal menghapus game'); window.location.href='index.php?route=admin_games';</script>";
        }
        break;
    case '/admin_pesan':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        $result = $bantuanModel->getAllPesan();
        view('admin_pesan.php', ['result' => $result]);
        break;
    case '/admin_transaksi':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=masuk");
            exit;
        }
        view('admin_transaksi.php', ['db' => $db]);
        break;
    case '/proses_bantuan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email'],
                'kategori' => $_POST['kategori'],
                'pesan' => $_POST['pesan']
            ];
            
            if ($bantuanModel->kirimPesan($data)) {
                echo "<script>alert('Pesan bantuan berhasil dikirim!'); window.location.href='index.php?route=bantuan';</script>";
            } else {
                echo "<script>alert('Gagal mengirim pesan bantuan!'); window.location.href='index.php?route=bantuan';</script>";
            }
        }
        break;
    case '/proses_daftar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role = $_POST['role'];

            if ($password !== $confirm_password) {
                echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href='index.php?route=daftar';</script>";
                exit;
            }

            $parts = explode('@', $email);
            $username = $parts[0];

            $stmt_check = $db->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt_check->bind_param("ss", $email, $username);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo "<script>alert('Email atau Username sudah terdaftar!'); window.location.href='index.php?route=daftar';</script>";
                exit;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (nama_lengkap, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $username, $email, $hashed_password, $role);
            
            if ($stmt->execute()) {
                echo "<script>alert('Pendaftaran berhasil! Silakan masuk.'); window.location.href='index.php?route=masuk';</script>";
            } else {
                echo "<script>alert('Gagal mendaftar!'); window.location.href='index.php?route=daftar';</script>";
            }
        }
        break;
    case '/lupa_password':
        view('lupa_password.php');
        break;
    case '/proses_lupa_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            if ($password !== $confirm_password) {
                $_SESSION['error_forgot'] = "Konfirmasi password tidak cocok!";
                header("Location: index.php?route=lupa_password");
                exit;
            }

            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param('si', $hashed_password, $user['id']);
                    if ($updateStmt->execute()) {
                        $_SESSION['success_forgot'] = "Password berhasil direset. Silakan login dengan password baru.";
                        header("Location: index.php?route=masuk");
                        exit;
                    }
                }
            }

            $_SESSION['error_forgot'] = "Email tidak ditemukan.";
            header("Location: index.php?route=lupa_password");
            exit;
        }
        break;
    case '/proses_masuk':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login_input = trim($_POST['username']);
            $password = trim($_POST['password']);

            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $login_input, $login_input);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $storedPassword = $user['password'];
                $validPassword = false;

                if (password_verify($password, $storedPassword)) {
                    $validPassword = true;
                } elseif ($password === $storedPassword) {
                    $validPassword = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                    if ($updateStmt) {
                        $updateStmt->bind_param('si', $newHash, $user['id']);
                        $updateStmt->execute();
                    }
                }

                if ($validPassword) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header("Location: index.php?route=admin_dashboard");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                }
            }

            $_SESSION['error_login'] = "Email atau password salah!";
            header("Location: index.php?route=masuk");
            exit;
        }
        break;
    case '/developer_dashboard':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?route=masuk"); exit; }
        require_once VIEWS_PATH . 'developer_dashboard.php';
        break;

    case '/developer_games':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?route=masuk"); exit; }
        $gameModel = new Game_model((new Database())->getConnection());
        $games = $gameModel->getGamesByDeveloper($_SESSION['user_id']);
        require_once VIEWS_PATH . 'developer_games.php';
        break;

    case '/developer_tambah_game':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?route=masuk"); exit; }
        $action = 'proses_developer_tambah_game';
        require_once VIEWS_PATH . 'developer_form_game.php';
        break;

    case '/proses_developer_tambah_game':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?route=masuk"); exit; }
        $gameModel = new Game_model((new Database())->getConnection());
        $gameModel->tambahGameDeveloper($_POST, $_FILES['gambar'] ?? null, $_SESSION['user_id']);
        header("Location: index.php?route=developer_games");
        exit;
        break;

    case '/developer_edit_game':
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) { header("Location: index.php?route=masuk"); exit; }
        $gameModel = new Game_model((new Database())->getConnection());
        $game = $gameModel->getGameById($_GET['id']);
        // Keamanan ganda: Hanya pemilik game yang bisa mengedit
        if ($game && $game['developer_id'] == $_SESSION['user_id']) {
            $action = 'proses_developer_edit_game&id=' . intval($_GET['id']);
            require_once VIEWS_PATH . 'developer_form_game.php';
        } else {
            header("Location: index.php?route=developer_games");
            exit;
        }
        break;

    case '/proses_developer_edit_game':
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) { header("Location: index.php?route=masuk"); exit; }
        $gameModel = new Game_model((new Database())->getConnection());
        $gameModel->updateGameDeveloper($_POST, $_FILES['gambar'] ?? null, $_GET['id'], $_SESSION['user_id']);
        header("Location: index.php?route=developer_games");
        exit;
        break;

    case '/developer_hapus_game':
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) { header("Location: index.php?route=masuk"); exit; }
        $gameModel = new Game_model((new Database())->getConnection());
        $gameModel->hapusGameDeveloper($_GET['id'], $_SESSION['user_id']);
        header("Location: index.php?route=developer_games");
        exit;
        break;
    case '/keluar':
        session_destroy();
        header("Location: index.php");
        exit;
        break;
    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "Route '" . htmlspecialchars($route) . "' tidak terdefinisi.";
        break;
}
