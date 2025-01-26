<?php
// Mulai sesi
session_start();
include 'db.php'; // Pastikan koneksi ke database sudah benar

// Pastikan pengguna sudah login
if (!isset($_SESSION['NPK'])) {
    header('Location: login_procces.php');
    exit();
}

// Ambil NPK dari sesi
$NPK = $_SESSION['NPK'];

// Default nama pengguna dan foto profil
$nama = 'Pengguna';
$foto = 'images/default-avatar.jpg'; // Path default jika foto tidak ditemukan

// Query untuk mengambil nama dan foto karyawan dari tabel dt_karyawan
$query = "SELECT nama, foto FROM dt_karyawan WHERE NPK = ?";
$stmt = $conn->prepare($query); // Menggunakan prepared statement
$stmt->bind_param("s", $NPK); // Menghubungkan parameter
$stmt->execute(); // Eksekusi query
$result = $stmt->get_result(); // Mendapatkan hasil query

// Periksa apakah data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row['nama']; // Ambil nama dari hasil query
    if (!empty($row['foto'])) {
        $foto = 'uploads/' . $row['foto']; // Path foto dari database
    }
}

// Tutup statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        /* Reset dasar */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            overflow-x: hidden; /* Pastikan tidak ada scroll horizontal */
        }

        /* Tombol Menu */
        .menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            cursor: pointer;
            font-size: 30px;
            color: #fff;
            background: #34495e;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Sidebar (menu) */
        .sidebar {
            position: fixed;
            top: 0;
            left: -220px; /* Sidebar tersembunyi pada awalnya */
            width: 220px;
            height: 100%;
            background: linear-gradient(180deg, #2c3e50, #34495e);
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease, opacity 0.3s ease; /* Efek geser untuk sidebar */
            z-index: 999; /* Pastikan sidebar di atas konten */
            opacity: 0; /* Menyembunyikan sidebar */
        }

        .sidebar h3 {
            color: #ecf0f1;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 10px 0;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #1abc9c;
            color: white;
        }

        /* Konten utama */
        .content {
            margin-left: 0; /* Konten tidak bergeser pada awalnya */
            margin-top: 70px;
            padding: 20px;
            max-width: 100%;
            transition: margin-left 0.3s ease; /* Efek pergeseran konten */
            height: 100vh; /* Menjadikan konten mengisi seluruh tinggi halaman */
            background-image: url('images/backdrnd_dt_krywn.jpg'); /* Ganti dengan path ke gambar di folder images */
            background-size: cover; /* Menyesuaikan gambar dengan ukuran konten */
            background-position: center; /* Memposisikan gambar di tengah */
            background-attachment: fixed; /* Menjaga gambar latar belakang tetap stabil */
            color: white; /* Mengubah warna teks menjadi putih agar kontras dengan latar belakang */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Agar gambar latar belakang menutupi halaman secara penuh */
        body {
            background-image: url('images/backdrnd_dt_krywn.jpg'); /* Ganti dengan path gambar yang sesuai */
            background-size: cover; /* Gambar menutupi seluruh body */
            background-position: center; /* Memposisikan gambar di tengah */
            background-attachment: fixed; /* Gambar tetap saat scroll */
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        /* Tambahan styling untuk profil pengguna */
        .profile-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            object-fit: cover;
        }

        .profile-container .edit-profile-btn {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .profile-container .edit-profile-btn:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>

    <!-- Tambahan untuk profil pengguna -->
    <div class="profile-container">
        <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto Profil">
        <form action="profil/edit_profil.php" method="get">
            <button type="submit" class="edit-profile-btn">Edit Profil</button>
        </form>
    </div>

    <!-- Tombol Menu -->
    <div class="menu-toggle" id="menu-icon">☰</div>

    <!-- Sidebar Menu -->
    <div class="sidebar" id="sidebar">
        <h3>Dashboard</h3>
        <a href="dashboard_user.php">Beranda</a>
        <a href="absensi_user.php">Absensi</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="content" id="content">
        <h2>Selamat Datang, <?php echo htmlspecialchars($nama); ?></h2>
        <p><strong>NPK:</strong> <?php echo htmlspecialchars($NPK); ?></p>
        <p>Selamat datang di dashboard. Silakan pilih menu di sidebar untuk absensi atau logout.</p>
    </div>

    <footer>
        &copy; 2025 Sistem Absensi
    </footer>

    <!-- Link ke JS -->
    <script src="js/dshbrd_user.js"></script>
</body>
</html>
