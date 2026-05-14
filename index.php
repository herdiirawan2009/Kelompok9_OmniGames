<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
$projectFolder = '/Kelompok9_OmniGames'; 

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

$database = new Database();
$db = $database->getConnection();
$gameModel = new Game_model($db);

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
    case '/katalog':
        $result = $gameModel->getAllGames();
        view('katalog.php', ['result' => $result]);
        break;
    case '/marketplace':
        view('marketplace.php', ['db' => $db]);
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
    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "Route '" . htmlspecialchars($route) . "' tidak terdefinisi.";
        break;
}