<?php
$host = 'localhost'; // Ganti dengan nama host database (biasanya 'localhost')
$user = 'root';      // Ganti dengan username database
$pass = '';          // Ganti dengan password database
$db   = 'db_absensi';     // Ganti dengan nama database yang digunakan

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>