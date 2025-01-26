<?php
// Mulai sesi
session_start();
include 'db.php';

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['NPK']) || $_SESSION['NPK'] !== '121104') {
    // Jika tidak, arahkan ke halaman login
    header('Location: index.php');
    exit();
}

// Ambil data admin dari sesi
$nama_admin = "Administrator"; // Nama admin statis, bisa diubah sesuai kebutuhan
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi Admin</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #74ebd5, #9face6);
            color: #333;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: #2c3e50;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            color: #f1c40f;
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            text-transform: uppercase;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar ul li a:hover {
            background: #34495e;
            transform: scale(1.05);
        }

        .content {
            margin-left: 250px;
            padding: 40px;
        }

        .content h1 {
            font-size: 28px;
            color: #2c3e50;
            text-align: center;
        }

        .dashboard-card {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 40px auto;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        .dashboard-card img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        .dashboard-card p {
            font-size: 20px;
            color: #34495e;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Administrator</h2>
        <ul>
            <li><a href="dashboard_admin.php">Beranda</a></li>
            <li><a href="dashboard_dt_krywn.php">Data Karyawan</a></li>
            <li><a href="data_user.php">Data User</a></li>
            <li><a href="data_jabatan.php">Data Jabatan</a></li>
            <li><a href="data_absensi_admin.php">Data Absensi</a></li>
            <li><a href="data_keterangan.php">Data Keterangan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Data Absensi</h1>
        <div class="dashboard-card">
            <img src="images/absensi_icon.png" alt="Absensi Icon">
            <p>Informasi Absensi Karyawan</p>
        </div>
    </div>
</body>
</html>
