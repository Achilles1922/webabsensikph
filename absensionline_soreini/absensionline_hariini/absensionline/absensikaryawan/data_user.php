<?php
include 'db.php'; // Menyertakan file koneksi database

// Proses Hapus Data
if (isset($_GET['delete'])) {
    $NPK = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM dt_karyawan WHERE NPK = ?");
    $stmt->bind_param("s", $NPK);
    
    if ($stmt->execute()) {
        echo "<p class='success'>Data karyawan berhasil dihapus!</p>";
        // Redirect setelah menghapus untuk mencegah refresh yang menghapus ulang data
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Menampilkan daftar data karyawan
$result = $conn->query("SELECT * FROM dt_karyawan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: bold;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Data Karyawan</h2>
    
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

    <table>
        <tr>
            <th>NPK</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Alamat</th>
            <th>Password</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        
        <?php
        // Menampilkan data karyawan
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['NPK'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['jabatan'] . "</td>";
            echo "<td>" . $row['alamat'] . "</td>";
            echo "<td>" . (strlen($row['password']) > 10 ? "Terenkripsi" : "Tidak Terenkripsi") . "</td>";
            echo "<td>" . $row['role'] . "</td>";
            echo "<td>
                    <a href='admin_edit_data_user.php?edit=" . $row['NPK'] . "'>Edit</a> | 
                    <a href='?delete=" . $row['NPK'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="dashboard_admin.php" class="back-button">Kembali ke Dashboard</a>
</body>
</html>
