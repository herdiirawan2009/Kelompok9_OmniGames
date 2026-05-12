<?php
class Game_model {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function getAllGames() {
        $query = "SELECT * FROM games";
        return $this->db->query($query);
    }
}