<?php
// ambil-pesan.php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'rizkyan'; // Ganti sesuai user database
$pass = 'rizkyan';     // Ganti sesuai password database
$db   = 'kontak_db'; // Ganti dengan nama database yang benar

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Koneksi database gagal']);
    exit;
}

$sql = "SELECT nama, pesan FROM pesan ORDER BY id DESC"; // Ganti nama tabel dari kontak_db ke pesan
$result = $conn->query($sql);

$pesan = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pesan[] = $row;
    }
}

echo json_encode($pesan);

$conn->close();
?>
