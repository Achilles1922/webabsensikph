<?php
include 'db.php'; // Menyertakan file koneksi database

// Proses Edit Data
if (isset($_GET['edit'])) {
    $NPK = $_GET['edit'];
    
    // Ambil data karyawan berdasarkan NPK
    $query = "SELECT * FROM dt_karyawan WHERE NPK = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $NPK);
    $stmt->execute();
    $result = $stmt->get_result();
    $karyawan = $result->fetch_assoc();
    $stmt->close();

    // Proses update data jika form di-submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
        $alamat = $_POST['alamat'];
        $password = $_POST['password'];

        // Jika password diisi, update password yang terenkripsi
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE dt_karyawan SET nama = ?, jabatan = ?, alamat = ?, password = ? WHERE NPK = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssss", $nama, $jabatan, $alamat, $hashed_password, $NPK);
        } else {
            // Jika password tidak diubah, hanya update nama, jabatan, dan alamat
            $update_query = "UPDATE dt_karyawan SET nama = ?, jabatan = ?, alamat = ? WHERE NPK = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssss", $nama, $jabatan, $alamat, $NPK);
        }

        if ($stmt->execute()) {
            $success = "Data karyawan berhasil diperbarui!";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    // Redirect jika tidak ada parameter edit
    header("Location: data_user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container input, .form-container textarea, .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        .back-button {
            display: block;
            width: 250px;
            margin: 20px auto;
            padding: 12px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none; /* Menghapus underline pada link */
        }

        .back-button:hover {
            background-color: #45a049;
            cursor: pointer; /* Menambahkan efek pointer saat hover */
            transform: scale(1.05); /* Efek sedikit membesar saat hover */
        }

        .back-button:active {
            background-color: #3e8e41; /* Mengubah warna tombol saat di-klik */
        }
    </style>
</head>
<body>
    <h2>Edit Data Karyawan</h2>
    
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

    <div class="form-container">
        <h3>Edit Data Karyawan</h3>
        <form method="POST" action="">
            <label>Nama:</label><br>
            <input type="text" name="nama" value="<?php echo $karyawan['nama']; ?>" required><br>

            <label>Jabatan:</label><br>
            <input type="text" name="jabatan" value="<?php echo $karyawan['jabatan']; ?>" required><br>

            <label>Alamat:</label><br>
            <textarea name="alamat" rows="4" required><?php echo $karyawan['alamat']; ?></textarea><br>

            <label>Password (Kosongkan jika tidak diubah):</label><br>
            <input type="password" name="password"><br>

            <button type="submit">Update</button>
        </form>
    </div>

    <a href="data_user.php" class="back-button">Kembali ke Daftar Karyawan</a>
</body>
</html>
