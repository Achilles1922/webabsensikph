<?php
// Mulai sesi
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['NPK'])) {
    header('Location: login_procces.php');
    exit();
}

// Ambil NPK dari sesi
$NPK = $_SESSION['NPK'];

// Inisialisasi pesan
$success_message = '';
$error_message = '';

// Koneksi ke database
$host = 'localhost';       // Ganti sesuai konfigurasi database Anda
$username = 'root';        // Username database
$password = '';            // Password database
$dbname = 'db_absensi';    // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengambil data nama karyawan berdasarkan NPK
$query_user = "SELECT nama FROM dt_karyawan WHERE NPK = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("s", $NPK);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// Cek apakah data ditemukan
if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $nama = $row['nama']; // Ganti 'nama_karyawan' dengan 'nama' jika sesuai
} else {
    $nama = 'Pengguna';  // Jika nama tidak ditemukan, tampilkan 'Pengguna'
}

// Menangani form absensi
if (isset($_POST['absen'])) {
    $keterangan = $_POST['keterangan'];

    // Validasi input
    if (!empty($keterangan)) {
        // Cek apakah pengguna sudah mengisi absensi hari ini
        $query_check = "SELECT * FROM tb_absensi WHERE NPK = ? AND tanggal = CURDATE()";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("s", $NPK); // Pastikan menggunakan parameter bind
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Jika sudah ada data absensi hari ini
            $error_message = "Anda sudah mengisi absen sebelumnya.";
        } else {
            // Jika belum ada absensi hari ini, simpan data absensi
            $query = "INSERT INTO tb_absensi (NPK, nama_karyawan, tanggal, keterangan) 
                      VALUES (?, ?, CURDATE(), ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $NPK, $nama, $keterangan); // Gunakan parameter bind untuk menghindari masalah

            if ($stmt->execute()) {
                $success_message = "Absensi berhasil disimpan! Keterangan: $keterangan";
            } else {
                $error_message = "Gagal menyimpan absensi: " . $conn->error;
            }
        }
    } else {
        $error_message = "Harap lengkapi semua data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi User</title>
    <style>
        /* Reset dasar */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background: linear-gradient(180deg, #2c3e50, #34495e);
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 70px;
            background-color: #34495e;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header .profile {
            display: flex;
            align-items: center;
        }

        .header .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #1abc9c;
            margin-right: 10px;
        }

        .header .profile span {
            font-size: 16px;
            font-weight: bold;
        }

        /* Content */
        .content {
            margin-left: 220px;
            margin-top: 70px;
            padding: 20px;
            max-width: calc(100% - 240px);
        }

        .content h2 {
            font-size: 24px;
            color: #34495e;
            margin-bottom: 20px;
            text-align: center;
            margin-top: 50px;
        }

        .content p {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
            color: #34495e;
        }

        form {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #34495e;
        }

        select, input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border-radius: 5px;
        }

        select {
            background: #f9f9f9;
            border: 1px solid #ccc;
        }

        button {
            background-color: #1abc9c;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #16a085;
        }

        .success, .error {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Dashboard</h3>
        <a href="dashboard_user.php">Beranda</a>
        <a href="absensi_user.php">Absensi</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Header -->
    <div class="header">
        <span>Absensi User</span>
        <div class="profile">
            <img src="images/profile.jpg" alt="Profil">
            <span><?php echo htmlspecialchars($nama); ?></span>
        </div>
    </div>

    <!-- Konten -->
    <div class="content">
        <h2>Selamat Datang, <?php echo htmlspecialchars($nama); ?></h2>
        <p><strong>NPK:</strong> <?php echo htmlspecialchars($NPK); ?></p>

        <form method="POST" action="absensi_user.php">
            <label for="keterangan">Keterangan Absensi:</label>
            <select name="keterangan" id="keterangan" required>
                <option value="" disabled selected>-- Pilih Keterangan Absensi --</option>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Tanpa Keterangan">Tanpa Keterangan</option>
            </select>

            <button type="submit" name="absen">Kirim Absensi</button>
        </form>

        <!-- Menampilkan pesan sukses atau error -->
        <?php if (!empty($success_message)): ?>
            <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
    </div>

    <footer>
        &copy; 2025 Sistem Absensi
    </footer>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
