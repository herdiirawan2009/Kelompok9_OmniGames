<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__); 
define('VIEWS_PATH', BASE_PATH . '/App/views/'); 

$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$projectFolder = '/Kelompok9_OmniGames'; 

$route = rtrim(str_replace($projectFolder, '', $requestUri), '/'); 
if (empty($route)) { $route = '/'; } 
function view($path, $data = []) {
    extract($data); 
    $filePath = VIEWS_PATH . $path;

    if (file_exists($filePath)) {
        require $filePath;
    } else {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "File tampilan (view) tidak ditemukan di: " . htmlspecialchars($filePath);
    }
}

// 5. Logika Routing
// Semua pemanggilan .html diubah menjadi .php
switch ($route) {
    case '/':
    case '/index.php':
    case '':
        // Memanggil file Beranda (ubah menjadi 'index.php' jika Anda menamainya index.php di dalam folder views)
        view('Beranda.php'); 
        break;
        
    case '/detail':
    case '/detail.php': // Ditambahkan agar aman jika user mengetik beserta ekstensinya
        view('detail.php');
        break;
        
    case '/katalog':
    case '/katalog.php':
        view('katalog.php');
        break;
        
    case '/marketplace':
    case '/marketplace.php':
        view('marketplace.php');
        break;
        
    case '/bantuan':
    case '/bantuan.php':
        view('bantuan.php');
        break;
        
    case '/masuk':
    case '/masuk.php':
        view('masuk.php');
        break;
        
    case '/daftar':
    case '/daftar.php':
        view('daftar.php');
        break;
        
    default:
        // Jika route tidak cocok, tampilkan 404
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "Halaman untuk route '" . htmlspecialchars($route) . "' belum dibuat.";
        break;
}