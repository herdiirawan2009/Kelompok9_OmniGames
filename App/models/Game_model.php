<?php
class Game_model {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function getAllGames() {
        $query = "SELECT * FROM games ORDER BY id ASC";
        return $this->db->query($query);
    }

    public function getPopuler() {
        $query = "SELECT * FROM games WHERE is_populer = 1 LIMIT 3";
        return $this->db->query($query);
    }

    public function getTerbaru() {
        $query = "SELECT * FROM games ORDER BY tanggal_rilis DESC LIMIT 3";
        return $this->db->query($query);
    }

    public function getGameById($id) {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUlasanByGameId($id) {
        $stmt = $this->db->prepare("SELECT * FROM ulasan WHERE game_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
}