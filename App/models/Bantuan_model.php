<?php
class Bantuan_model {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function kirimPesan($data) {
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
}