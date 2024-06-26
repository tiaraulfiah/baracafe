<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Form Pemesanan Menu</h1>
        <form method="POST" action="rincian_pesanan.php">
            <label for="nama_customer">Nama Customer:</label>
            <input type="text" id="nama_customer" name="nama_customer" required>

            <label for="makanan">Pilih Makanan:</label>
            <select id="makanan" name="makanan">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'cafe_database');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $result = $conn->query("SELECT * FROM menu WHERE jenis='makanan'");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_menu']}'>{$row['nama']} - Rp " . number_format($row['harga'], 2) . "</option>";
                }
                $conn->close();
                ?>
            </select>

            <label for="minuman">Pilih Minuman:</label>
            <select id="minuman" name="minuman">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'cafe_database');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $result = $conn->query("SELECT * FROM menu WHERE jenis='minuman'");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_menu']}'>{$row['nama']} - Rp " . number_format($row['harga'], 2) . "</option>";
                }
                $conn->close();
                ?>
            </select>

            <button type="submit">Simpan Pesanan</button>
        </form>
        <br>
        <a href="index.php" class="button">Kembali</a>
    </div>
</body>
</html>

