<?php
include 'db.php'; // Menyertakan file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NPK = $_POST['NPK'];
    $nama = $_POST['nama']; // Menambahkan nama
    $jabatan = $_POST['jabatan']; // Menambahkan jabatan
    $alamat = $_POST['alamat']; // Menambahkan alamat
    $password = $_POST['password'];
    $role = 'user'; // Role default untuk karyawan

    // Validasi input kosong
    if (empty($NPK) || empty($nama) || empty($jabatan) || empty($alamat) || empty($password)) {
        $error = "Semua field harus diisi!";
    } elseif (!ctype_digit($NPK)) { // Validasi agar NPK hanya angka
        $error = "NPK hanya boleh berisi angka!";
    } else {
        // Enkripsi password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data ke database menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO dt_karyawan (NPK, nama, jabatan, alamat, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $NPK, $nama, $jabatan, $alamat, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Error: " . $stmt->error;
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
    <title>Daftar</title>

    <!-- CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            width: 300px;
            margin: auto;
        }
        label {
            font-weight: bold;
        }
        input, button, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
        }
    </style>
    <!-- CSS selesai -->
</head>
<body>
    <h2 style="text-align: center;">Form Pendaftaran Karyawan</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST" action="">
        <label>NPK:</label><br>
        <input type="number" name="NPK" required><br>

        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br> <!-- Input untuk nama -->

        <label>Jabatan:</label><br>
        <input type="text" name="jabatan" required><br><br> <!-- Input untuk jabatan -->

        <label>Alamat:</label><br>
        <textarea name="alamat" rows="4" required></textarea><br><br> <!-- Input untuk alamat -->

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br> <!-- Input untuk password -->

        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
    <script>
        // Validasi tambahan dengan JavaScript agar NPK hanya angka
        document.querySelector('input[name="NPK"]').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, ''); // Hapus semua karakter selain angka
        });
    </script>
</body>
</html>
