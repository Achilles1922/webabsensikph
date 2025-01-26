<?php
$servername = "localhost";
$username = "root";  // Sesuaikan dengan username MySQL Anda
$password = "";      // Sesuaikan dengan password MySQL Anda
$database = "db_absensi";  // Pastikan nama database sesuai

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mulai sesi
session_start();
include 'db.php'; // Menyertakan file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NPK = $_POST['NPK'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($NPK) || empty($password)) {
        $error = "Semua field harus diisi!";
    } else {
        // Cek apakah NPK ada di database (tabel tb_admin)
        $stmt = $conn->prepare("SELECT * FROM tb_admin WHERE NPK = ?");
        $stmt->bind_param("s", $NPK);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Ambil data pengguna dari database
            $user = $result->fetch_assoc();

            // Verifikasi password
            if ($password === $user['password']) {
                // Jika login berhasil, simpan data pengguna ke sesi
                $_SESSION['NPK'] = $user['NPK']; // Simpan NPK ke sesi
                $_SESSION['role'] = 'admin'; // Simpan role admin ke sesi

                // Arahkan ke halaman dashboard admin
                header('Location: dashboard_admin.php');
                exit();
            } else {
                $error = "NPK atau password salah!";
            }
        } else {
            $error = "Login gagal, silahkan daftar";
        }

        $stmt->close();
    }
}
?>

<?php
$servername = "localhost";
$username = "root";  // Sesuaikan dengan username MySQL Anda
$password = "";      // Sesuaikan dengan password MySQL Anda
$database = "db_absensi";  // Pastikan nama database sesuai

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mulai sesi
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NPK = $_POST['NPK'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($NPK) || empty($password)) {
        $error = "Semua field harus diisi!";
    } else {
        // Cek apakah NPK ada di database (tabel dt_karyawan)
        $stmt = $conn->prepare("SELECT NPK, password FROM dt_karyawan WHERE NPK = ?");
        $stmt->bind_param("s", $NPK);
        $stmt->execute();

        if ($stmt->error) {
            die("Query error: " . $stmt->error);  // Menampilkan error jika ada masalah dalam eksekusi query
        }

        $result = $stmt->get_result();

        // Debugging: Tampilkan hasil query
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Debugging: Menampilkan data user yang ditemukan
            var_dump($user); // Hanya untuk debugging
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Jika login berhasil, simpan data pengguna ke sesi
                $_SESSION['NPK'] = $user['NPK']; // Simpan NPK ke sesi
                $_SESSION['role'] = 'user'; // Simpan role user ke sesi

                // Arahkan ke halaman dashboard_user
                header('Location: dashboard_user.php');
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "NPK tidak terdaftar!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
</head>
<body>
    <h2>Login User</h2>
    
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="">
        <label>NPK:</label><br>
        <input type="text" name="NPK" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
