<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pemesanan Menu</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            text-align: center;
            padding: 50px 20px;
        }
        .menu-options {
            display: inline-block;
            margin-top: 20px;
        }
        .menu-options .button {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }
        .menu-options .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Bara Cafe</h1>
        <div class="menu-options">
            <a href="lihat_menu.php" class="button">Lihat Menu</a>
            <a href="pesan_menu.php" class="button">Pesan Menu</a>
        </div>
    </div>
</body>
</html>
