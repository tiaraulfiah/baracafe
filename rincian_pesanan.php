<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Rincian Pesanan</h1>

        <?php
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'cafe_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Proses untuk menghandle edit pesanan jika ada parameter id_pesanan dari URL
        if (isset($_GET['id_pesanan'])) {
            $id_pesanan = $_GET['id_pesanan'];

            // Jika terdapat parameter id_pesanan, tampilkan form untuk edit pesanan
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nama_customer = $_POST['nama_customer'];
                $id_makanan = $_POST['makanan'];
                $id_minuman = $_POST['minuman'];

                // Query untuk mendapatkan harga makanan dan minuman
                $query_harga_makanan = "SELECT harga FROM menu WHERE id_menu = $id_makanan";
                $result_harga_makanan = $conn->query($query_harga_makanan);
                $harga_makanan = $result_harga_makanan->fetch_assoc()['harga'];

                $query_harga_minuman = "SELECT harga FROM menu WHERE id_menu = $id_minuman";
                $result_harga_minuman = $conn->query($query_harga_minuman);
                $harga_minuman = $result_harga_minuman->fetch_assoc()['harga'];

                // Hitung total harga
                $total_harga = $harga_makanan + $harga_minuman;

                // Query untuk update pesanan dengan total harga
                $query_update = "UPDATE pesanan SET nama_customer='$nama_customer', id_makanan=$id_makanan, id_minuman=$id_minuman, total_harga=$total_harga WHERE id_pesanan=$id_pesanan";

                if ($conn->query($query_update) === TRUE) {
                    echo "Data pesanan berhasil diperbarui.";
                } else {
                    echo "Error: " . $query_update . "<br>" . $conn->error;
                }
            }

            // Query untuk mendapatkan detail pesanan berdasarkan id_pesanan
            $query_select = "SELECT pesanan.id_pesanan, pesanan.nama_customer, menu_makanan.nama AS makanan, menu_minuman.nama AS minuman, menu_makanan.harga AS harga_makanan, menu_minuman.harga AS harga_minuman, pesanan.total_harga
                            FROM pesanan
                            INNER JOIN menu AS menu_makanan ON pesanan.id_makanan = menu_makanan.id_menu
                            INNER JOIN menu AS menu_minuman ON pesanan.id_minuman = menu_minuman.id_menu
                            WHERE pesanan.id_pesanan = $id_pesanan";
            $result_select = $conn->query($query_select);

            if ($result_select->num_rows == 1) {
                $row = $result_select->fetch_assoc();
                $nama_customer = $row['nama_customer'];
                $makanan = $row['makanan'];
                $harga_makanan = $row['harga_makanan'];
                $minuman = $row['minuman'];
                $harga_minuman = $row['harga_minuman'];
                $total_harga = $row['total_harga'];

                // Form untuk edit pesanan
                echo "<form method='POST' action='rincian_pesanan.php?id_pesanan=$id_pesanan'>";
                echo "<label for='nama_customer'>Nama Customer:</label>";
                echo "<input type='text' id='nama_customer' name='nama_customer' value='$nama_customer' required>";

                echo "<label for='makanan'>Pilih Makanan:</label>";
                echo "<select id='makanan' name='makanan'>";
                $result_makanan = $conn->query("SELECT * FROM menu WHERE jenis='makanan'");
                while ($row_makanan = $result_makanan->fetch_assoc()) {
                    $selected = ($row_makanan['id_menu'] == $row['id_makanan']) ? "selected" : "";
                    echo "<option value='{$row_makanan['id_menu']}' $selected>{$row_makanan['nama']} - Rp " . number_format($row_makanan['harga'], 2) . "</option>";
                }
                echo "</select>";

                echo "<label for='minuman'>Pilih Minuman:</label>";
                echo "<select id='minuman' name='minuman'>";
                $result_minuman = $conn->query("SELECT * FROM menu WHERE jenis='minuman'");
                while ($row_minuman = $result_minuman->fetch_assoc()) {
                    $selected = ($row_minuman['id_menu'] == $row['id_minuman']) ? "selected" : "";
                    echo "<option value='{$row_minuman['id_menu']}' $selected>{$row_minuman['nama']} - Rp " . number_format($row_minuman['harga'], 2) . "</option>";
                }
                echo "</select>";

                echo "<button type='submit'>Simpan Perubahan</button>";
                echo "</form>";

                // Tampilkan hasil pesanan
                echo "<h2>Hasil Pesanan:</h2>";
                echo "<p>Nama Customer: $nama_customer</p>";
                echo "<p>Makanan: $makanan - Rp " . number_format($harga_makanan, 2) . "</p>";
                echo "<p>Minuman: $minuman - Rp " . number_format($harga_minuman, 2) . "</p>";
                echo "<p>Total Harga: Rp " . number_format($total_harga, 2) . "</p>";
            } else {
                echo "Pesanan tidak ditemukan atau terjadi kesalahan dalam mengambil data.";
            }
        } else {
            // Jika tidak ada parameter id_pesanan dari URL, tampilkan form untuk input pesanan baru
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nama_customer = $_POST['nama_customer'];
                $id_makanan = $_POST['makanan'];
                $id_minuman = $_POST['minuman'];

                // Query untuk mendapatkan harga makanan dan minuman
                $query_harga_makanan = "SELECT harga FROM menu WHERE id_menu = $id_makanan";
                $result_harga_makanan = $conn->query($query_harga_makanan);
                $harga_makanan = $result_harga_makanan->fetch_assoc()['harga'];

                $query_harga_minuman = "SELECT harga FROM menu WHERE id_menu = $id_minuman";
                $result_harga_minuman = $conn->query($query_harga_minuman);
                $harga_minuman = $result_harga_minuman->fetch_assoc()['harga'];

                // Hitung total harga
                $total_harga = $harga_makanan + $harga_minuman;

                // Query untuk insert pesanan baru
                $query_insert = "INSERT INTO pesanan (nama_customer, id_makanan, id_minuman, total_harga) VALUES ('$nama_customer', $id_makanan, $id_minuman, $total_harga)";

                if ($conn->query($query_insert) === TRUE) {
                    echo "Data pesanan berhasil disimpan.";
                    // Ambil ID pesanan yang baru saja diinsert
                    $id_pesanan_baru = $conn->insert_id;
                    // Redirect ke halaman rincian pesanan untuk pesanan yang baru saja diinput
                    header("Location: rincian_pesanan.php?id_pesanan=$id_pesanan_baru");
                    exit;
                } else {
                    echo "Error: " . $query_insert . "<br>" . $conn->error;
                }
            }

            // Form untuk input pesanan baru
            echo "<form method='POST' action='rincian_pesanan.php'>";
            echo "<label for='nama_customer'>Nama Customer:</label>";
            echo "<input type='text' id='nama_customer' name='nama_customer' required>";

            echo "<label for='makanan'>Pilih Makanan:</label>";
            echo "<select id='makanan' name='makanan'>";
            $result_makanan = $conn->query("SELECT * FROM menu WHERE jenis='makanan'");
            while ($row_makanan = $result_makanan->fetch_assoc()) {
                echo "<option value='{$row_makanan['id_menu']}'>{$row_makanan['nama']} - Rp " . number_format($row_makanan['harga'], 2) . "</option>";
            }
            echo "</select>";

            echo "<label for='minuman'>Pilih Minuman:</label>";
            echo "<select id='minuman' name='minuman'>";
            $result_minuman = $conn->query("SELECT * FROM menu WHERE jenis='minuman'");
            while ($row_minuman = $result_minuman->fetch_assoc()) {
                echo "<option value='{$row_minuman['id_menu']}'>{$row_minuman['nama']} - Rp " . number_format($row_minuman['harga'], 2) . "</option>";
            }
            echo "</select>";

            echo "<button type='submit'>Simpan Pesanan</button>";
            echo "</form>";
        }

        // Tutup koneksi database
        $conn->close();
        ?>

        <br>
        <a href="index.php" class="button">Kembali</a>
    </div>
</body>
</html>