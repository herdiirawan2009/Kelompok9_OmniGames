<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__); 
define('VIEWS_PATH', BASE_PATH . '/App/views/'); 
define('MODELS_PATH', BASE_PATH . '/App/models/'); 


if (file_exists(MODELS_PATH . 'Database.php')) {
    require_once MODELS_PATH . 'Database.php';
} else {
    require_once VIEWS_PATH . 'Database.php';
}

$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


$projectFolder = '/Kelompok9_OmniGames'; 

$route = str_replace($projectFolder, '', $requestUri); 
$route = str_replace('//', '/', $route); 
$route = rtrim($route, '/'); 

if (empty($route)) { $route = '/'; }

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

switch ($route) {
    case '/':
    case '/index.php':
    case '':
        view('Beranda.php'); 
        break;
    case '/detail':
        view('detail.php');
        break;
    case '/katalog':
        view('katalog.php');
        break;
    case '/marketplace':
        view('marketplace.php');
        break;
    case '/bantuan':
        view('bantuan.php');
        break;
    case '/masuk':
        view('masuk.php');
        break;
    case '/daftar':
        view('daftar.php');
        break;
    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "Route '" . htmlspecialchars($route) . "' tidak terdefinisi.";
        break;
}