<?php
class Game_model {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPopuler() {
        $query = "SELECT * FROM games ORDER BY rating DESC LIMIT 4";
        return $this->conn->query($query);
    }

    public function getTerbaru() {
        $query = "SELECT * FROM games ORDER BY id DESC LIMIT 4";
        return $this->conn->query($query);
    }

    public function getPopulerAll() {
        $query = "SELECT * FROM games ORDER BY rating DESC";
        return $this->conn->query($query);
    }

    public function getTerbaruAll() {
        $query = "SELECT * FROM games ORDER BY id DESC";
        return $this->conn->query($query);
    }

    public function getGameById($id) {
        $id = intval($id);
        $query = "SELECT * FROM games WHERE id = $id";
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function getUlasanByGameId($id) {
        $id = intval($id);
        $query = "SELECT * FROM ulasan WHERE game_id = $id ORDER BY id DESC";
        return $this->conn->query($query);
    }

    public function tambahUlasan($game_id, $nama_user, $rating, $komentar) {
        $query = "INSERT INTO ulasan (game_id, nama_user, rating_user, komentar) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('isis', $game_id, $nama_user, $rating, $komentar);
        return $stmt->execute();
    }

    public function getAllGames($kategori = 'all', $urut = 'popular', $keyword = '') {
        $query = "SELECT * FROM games WHERE 1=1";
        
        if ($kategori !== 'all') {
            $kategori = $this->conn->real_escape_string($kategori);
            $query .= " AND genre LIKE '%$kategori%'";
        }

        if ($keyword !== '') {
            $keyword = $this->conn->real_escape_string($keyword);
            $query .= " AND (judul LIKE '%$keyword%' OR genre LIKE '%$keyword%' OR spesifikasi LIKE '%$keyword%')";
        }
        
        if ($urut === 'new') {
            $query .= " ORDER BY id DESC";
        } elseif ($urut === 'price-low') {
            $query .= " ORDER BY harga ASC";
        } elseif ($urut === 'price-high') {
            $query .= " ORDER BY harga DESC";
        } else {
            $query .= " ORDER BY rating DESC";
        }
        
        return $this->conn->query($query);
    }

    public function getGamesPaged($kategori = 'all', $urut = 'popular', $keyword = '', $page = 1, $perPage = 9) {
        $page = max(1, intval($page));
        $perPage = max(1, intval($perPage));

        $where = "WHERE 1=1";

        if ($kategori !== 'all') {
            $kategori = $this->conn->real_escape_string($kategori);
            $where .= " AND genre LIKE '%$kategori%'";
        }

        if ($keyword !== '') {
            $keyword = $this->conn->real_escape_string($keyword);
            $where .= " AND (judul LIKE '%$keyword%' OR genre LIKE '%$keyword%' OR spesifikasi LIKE '%$keyword%')";
        }

        $orderBy = " ORDER BY rating DESC";
        if ($urut === 'new') {
            $orderBy = " ORDER BY id DESC";
        } elseif ($urut === 'price-low') {
            $orderBy = " ORDER BY harga ASC";
        } elseif ($urut === 'price-high') {
            $orderBy = " ORDER BY harga DESC";
        }

        $countQuery = "SELECT COUNT(*) as cnt FROM games $where";
        $countResult = $this->conn->query($countQuery);
        $total = 0;
        if ($countResult) {
            $r = $countResult->fetch_assoc();
            $total = intval($r['cnt']);
        }

        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
        $offset = ($page - 1) * $perPage;

        $query = "SELECT * FROM games $where" . $orderBy . " LIMIT $offset, $perPage";
        $result = $this->conn->query($query);

        return [
            'result' => $result,
            'total_pages' => $totalPages,
            'total_items' => $total,
        ];
    }


    public function tambahGame($data, $file) {
        $judul = $this->conn->real_escape_string($data['judul']);
        $genre = $this->conn->real_escape_string($data['genre']);
        $harga = intval($data['harga']);
        $rating = floatval($data['rating']);
        $spesifikasi = $this->conn->real_escape_string($data['spesifikasi']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);
        $gambar = '';

        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '' && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/Image/';
            $gambar = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadDir . $gambar);
        }

        $query = "INSERT INTO games (judul, genre, harga, rating, spesifikasi, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssiddss', $judul, $genre, $harga, $rating, $spesifikasi, $deskripsi, $gambar);
        return $stmt->execute();
    }

    public function editGame($id, $data, $file) {
        $id = intval($id);
        $judul = $this->conn->real_escape_string($data['judul']);
        $genre = $this->conn->real_escape_string($data['genre']);
        $harga = intval($data['harga']);
        $rating = floatval($data['rating']);
        $spesifikasi = $this->conn->real_escape_string($data['spesifikasi']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);
        $gambar = '';

        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '' && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/Image/';
            $gambar = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadDir . $gambar);
        }

        if ($gambar !== '') {
            $query = "UPDATE games SET judul = ?, genre = ?, harga = ?, rating = ?, spesifikasi = ?, deskripsi = ?, gambar = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssiddssi', $judul, $genre, $harga, $rating, $spesifikasi, $deskripsi, $gambar, $id);
        } else {
            $query = "UPDATE games SET judul = ?, genre = ?, harga = ?, rating = ?, spesifikasi = ?, deskripsi = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssiddsi', $judul, $genre, $harga, $rating, $spesifikasi, $deskripsi, $id);
        }

        return $stmt->execute();
    }

    public function hapusGame($id) {
        $id = intval($id);
        $query = "DELETE FROM games WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getGamesByDeveloper($developer_id) {
        $dev_id = intval($developer_id);
        $query = "SELECT * FROM games WHERE developer_id = $dev_id ORDER BY id DESC";
        return $this->conn->query($query);
    }

    public function tambahGameDeveloper($data, $file, $developer_id) {
        $judul = $this->conn->real_escape_string($data['judul']);
        $genre = $this->conn->real_escape_string($data['genre']);
        $harga = intval($data['harga']);
        $spesifikasi = $this->conn->real_escape_string($data['spesifikasi']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);
        $rating = 0;

        $gambar = '';
        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '' && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/Image/';
            $gambar = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadDir . $gambar);
        }

        $query = "INSERT INTO games (developer_id, judul, genre, harga, rating, spesifikasi, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('issidsss', $developer_id, $judul, $genre, $harga, $rating, $spesifikasi, $deskripsi, $gambar);
        return $stmt->execute();
    }

    public function updateGameDeveloper($data, $file, $id, $developer_id) {
        $id = intval($id);
        $dev_id = intval($developer_id);
        $judul = $this->conn->real_escape_string($data['judul']);
        $genre = $this->conn->real_escape_string($data['genre']);
        $harga = intval($data['harga']);
        $spesifikasi = $this->conn->real_escape_string($data['spesifikasi']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);

        $gambar = '';
        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '' && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/Image/';
            $gambar = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadDir . $gambar);
        }

        if ($gambar !== '') {
            $query = "UPDATE games SET judul = ?, genre = ?, harga = ?, spesifikasi = ?, deskripsi = ?, gambar = ? WHERE id = ? AND developer_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssisssii', $judul, $genre, $harga, $spesifikasi, $deskripsi, $gambar, $id, $dev_id);
        } else {
            $query = "UPDATE games SET judul = ?, genre = ?, harga = ?, spesifikasi = ?, deskripsi = ? WHERE id = ? AND developer_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssissii', $judul, $genre, $harga, $spesifikasi, $deskripsi, $id, $dev_id);
        }
        return $stmt->execute();
    }

    public function hapusGameDeveloper($id, $developer_id) {
        $id = intval($id);
        $dev_id = intval($developer_id);
        $query = "DELETE FROM games WHERE id = ? AND developer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $id, $dev_id);
        return $stmt->execute();
    }
}
?>
