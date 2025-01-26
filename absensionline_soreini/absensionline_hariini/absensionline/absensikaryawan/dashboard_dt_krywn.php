<?php
include 'db.php'; // Pastikan file ini berisi koneksi database

// Fungsi untuk menambahkan data karyawan
if (isset($_POST['add'])) {
    $npk = mysqli_real_escape_string($conn, $_POST['npk']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Password dalam bentuk teks biasa

    // Simpan password langsung tanpa enkripsi
    $query = "INSERT INTO karyawan (npk, nama, jabatan, alamat, password) VALUES ('$npk', '$nama', '$jabatan', '$alamat', '$password')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard_dt_krywn.php'); // Redirect ke halaman ini setelah tambah data
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fungsi untuk mengedit data karyawan
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $npk = mysqli_real_escape_string($conn, $_POST['npk']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Password dalam bentuk teks biasa

    // Jika password tidak kosong, simpan password baru
    if (!empty($password)) {
        $query = "UPDATE karyawan SET npk='$npk', nama='$nama', jabatan='$jabatan', alamat='$alamat', password='$password' WHERE id=$id";
    } else {
        // Jika password kosong, hanya update kolom lain tanpa password
        $query = "UPDATE karyawan SET npk='$npk', nama='$nama', jabatan='$jabatan', alamat='$alamat' WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        header('Location: dashboard_dt_krywn.php'); // Redirect ke halaman ini setelah edit data
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fungsi untuk menghapus data karyawan
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Pastikan id adalah integer

    // Query untuk menghapus data berdasarkan id
    $query = "DELETE FROM karyawan WHERE id = $id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard_dt_krywn.php'); // Redirect ke halaman ini setelah hapus data
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <style>
        /* Resetting some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply full background image */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            background-image: ('backdrnd_dt_krywn.jpg'); /* Ganti dengan URL gambar Anda */
            background-size: cover; /* Membuat gambar menutupi seluruh latar belakang */
            background-position: center; /* Menempatkan gambar di tengah layar */
            background-attachment: fixed; /* Membuat gambar tetap saat scroll */
        }

        /* Style content area with a semi-transparent background */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang putih transparan */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        /* Style the form */
        form {
            background-color: #fff;
            padding: 20px;
            margin: 10px auto;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #218838;
        }

        /* Style the table */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Style the edit and delete link */
        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            form {
                width: 90%;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <a href="dashboard_admin.php" class="back-button">Kembali ke Halaman Admin</a>

    <h1>Data Karyawan</h1>

    <!-- Form Tambah Data -->
    <form method="POST" action="">
        <input type="text" name="npk" placeholder="NPK" required>
        <input type="text" name="nama" placeholder="Nama Karyawan" required>
        <input type="text" name="jabatan" placeholder="Jabatan" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add">Tambah</button>
    </form>

    <!-- Tabel Data Karyawan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NPK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Alamat</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data karyawan
            $query = "SELECT * FROM karyawan";
            $result = mysqli_query($conn, $query);
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['npk']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($row['jabatan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                echo "<td>
                    <a href='?edit=" . $row['id'] . "'>Edit</a> | 
                    <a href='?delete=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Form Edit Data -->
    <?php if (isset($_GET['edit'])): ?>
        <?php
        // Periksa apakah parameter 'edit' ada
        $id = intval($_GET['edit']);
        $query = "SELECT * FROM karyawan WHERE id=$id";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
        ?>
        <h2>Edit Data Karyawan</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <input type="text" name="npk" value="<?php echo htmlspecialchars($data['npk']); ?>" required>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            <input type="text" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan']); ?>" required>
            <input type="text" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
            <input type="password" name="password" placeholder="Password Baru (Kosongkan jika tidak ingin mengubah)">
            <button type="submit" name="edit">Simpan Perubahan</button>
        </form>
        <?php 
            } else {
                echo "<p>Data tidak ditemukan!</p>";
            }
        ?>
    <?php endif; ?>

</body>
</html>
