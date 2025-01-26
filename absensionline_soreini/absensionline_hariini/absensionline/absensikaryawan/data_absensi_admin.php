<?php
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

// Query untuk mengambil data absensi, gabungkan tanggal dan waktu_absen
$query = "SELECT 
            tb_absensi.id, 
            tb_absensi.NPK, 
            dt_karyawan.nama, 
            DATE_FORMAT(tb_absensi.tanggal, '%d-%m-%Y') AS tanggal_formatted,
            TIME_FORMAT(tb_absensi.waktu_absen, '%H:%i:%s') AS waktu_formatted,
            tb_absensi.keterangan 
          FROM tb_absensi
          LEFT JOIN dt_karyawan ON tb_absensi.NPK = dt_karyawan.NPK
          ORDER BY tb_absensi.tanggal DESC";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi Admin</title>
    <style>
        /* CSS Styling Anda */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #74ebd5, #9face6);
            color: #333;
        }

        .menu-toggle {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            cursor: pointer;
        }

        .menu-toggle span {
            font-size: 24px;
            color: white;
            background: #2c3e50;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .menu-toggle span:hover {
            background: #34495e;
            transform: scale(1.1);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: none; /* Sidebar disembunyikan pada awalnya */
        }

        .sidebar h2 {
            color: #f1c40f;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #1abc9c;
        }

        .sidebar ul li a.active {
            background-color: #16a085;
        }

        .content {
            margin-left: 0;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        .content h1 {
            text-align: center;
            font-size: 30px;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: red;
            text-decoration: none;
        }

        a:hover {
            color: #e74c3c;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>

<!-- Tombol untuk toggle sidebar -->
<div class="menu-toggle">
    <span id="menu-icon">☰</span>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Administrator</h2>
    <ul>
        <li><a href="dashboard_admin.php" class="active">Dashboard</a></li>
        <li><a href="data_absensi_admin.php">Data Absensi</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- Konten -->
<div class="content">
    <h1>Data Absensi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NPK</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $nama_karyawan = $row['nama'] ?? 'Tidak Ditemukan';
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['NPK']}</td>
                        <td>{$nama_karyawan}</td>
                        <td>{$row['tanggal_formatted']}</td>
                        <td>{$row['waktu_formatted']}</td>
                        <td>{$row['keterangan']}</td>
                        <td><a href='data_absensi_admin.php?id={$row['id']}'>Hapus</a></td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data absensi.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Memasukkan file JavaScript yang baru -->
<script src="js/menu_dt_absensi.js"></script>

</body>
</html>

<?php
$conn->close();
?>
