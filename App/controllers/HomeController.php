<?php
class HomeController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $model = new Game_model($db);

        $games = $model->getAllGames();

        require_once 'App/views/Beranda.php';
    }
}