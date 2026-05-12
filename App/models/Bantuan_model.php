<?php
class Bantuan_model {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function kirimPesan($data) {
        $query = "INSERT INTO kontak_admin (nama, email, kategori, pesan) VALUES (?, ?, ?, ?)";
    }
}