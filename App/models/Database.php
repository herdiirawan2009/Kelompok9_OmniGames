<?php
class Database {
    private $host;
    private $user;
    private $pass;
    private $db_name;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost';
        $this->user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
        $this->pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        $this->db_name = getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'omnigames';
    }

    public function getConnection() {
        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
            if ($this->conn->connect_errno) {
                throw new Exception("Koneksi gagal: " . $this->conn->connect_error);
            }
            $this->conn->set_charset('utf8mb4');
            return $this->conn;
        } catch (Exception $e) {
            error_log($e->getMessage());
            die("Terjadi kesalahan koneksi database. Periksa konfigurasi.");
        }
    }

    public function closeConnection() {
        if ($this->conn instanceof mysqli) {
            $this->conn->close();
        }
    }
}
?>