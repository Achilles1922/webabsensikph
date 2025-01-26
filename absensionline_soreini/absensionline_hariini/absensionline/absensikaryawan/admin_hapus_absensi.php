<?php
// Mulai sesi
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['NPK']) || $_SESSION['NPK'] !== '121104') {
    header('Location: index.php');
    exit();
}

// Koneksi ke database
$host = 'localhost';       // Sesuaikan konfigurasi
$username = 'root';        // Username database
$password = '';            // Password database
$dbname = 'db_absensi';    // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Menangani penghapusan absensi
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus absensi
    $query = "DELETE FROM tb_absensi WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        // Redirect setelah berhasil menghapus data
        header('Location: data_absensi_admin.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
