<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Menu</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Menu</h1>
        <?php
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'cafe_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query untuk mengambil semua menu
        $result = $conn->query("SELECT * FROM menu");

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nama</th><th>Jenis</th><th>Harga</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . ucfirst($row['jenis']) . "</td>";
                echo "<td>Rp " . number_format($row['harga'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Tidak ada menu yang tersedia.";
        }

        $conn->close();
        ?>
        <br>
        <a href="index.php" class="button">Kembali</a>
    </div>
</body>
</html>
