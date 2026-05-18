<?php
class Bantuan_model {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    private function ensureKontakAdminTable() {
        $query = "CREATE TABLE IF NOT EXISTS kontak_admin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            kategori VARCHAR(100) NOT NULL,
            pesan TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        return $this->db->query($query);
    }

    public function kirimPesan($data) {
        $this->ensureKontakAdminTable();
        $query = "INSERT INTO kontak_admin (nama, email, kategori, pesan) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param(
                "ssss", 
                $data['nama'], 
                $data['email'], 
                $data['kategori'], 
                $data['pesan']
            );
            return $stmt->execute();
        }
        return false;
    }

    public function getAllPesan() {
        if (!$this->ensureKontakAdminTable()) {
            return false;
        }
        $query = "SELECT * FROM kontak_admin ORDER BY id DESC";
        return $this->db->query($query);
    }
}