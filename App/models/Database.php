<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = ""; 
    private $db_name = "omnigames"; 
    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>