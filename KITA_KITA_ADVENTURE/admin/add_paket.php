<?php
// admin/add_paket.php
require_once '../config/database.php';
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = null;

    // Validasi dasar
    if (!$nama) {
        $errors[] = "Nama paket wisata harus diisi.";
    }
    if (!$deskripsi) {
        $errors[] = "Deskripsi paket wisata harus diisi.";
    }

    // Validasi & upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../images/';
        $filename = basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $filename;
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Format gambar harus JPG, JPEG, PNG, atau GIF.";
        } else {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
                $gambar = 'images/' . $filename;
            } else {
                $errors[] = "Gagal mengunggah gambar.";
            }
        }
    } else {
        $errors[] = "Gambar harus dipilih.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO paket_wisata (nama, deskripsi, gambar) VALUES (
            '" . mysqli_real_escape_string($conn, $nama) . "',
            '" . mysqli_real_escape_string($conn, $deskripsi) . "',
            '" . mysqli_real_escape_string($conn, $gambar) . "'
        )";

        if (mysqli_query($conn, $sql)) {
            $success = true;
            $nama = $deskripsi = '';
        } else {
            $errors[] = "Gagal menambah paket wisata: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Paket Wisata - Admin Pesona Sumut</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            margin: 0; padding: 0;
        }
        header {
            background-color: #007f5f;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 2px;
        }
        nav {
            background: #2a9d8f;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 1rem 0;
            font-weight: 600;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1.3rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #74c69d;
            color: #014f28;
        }
        main {
            max-width: 520px;
            margin: 2.5rem auto;
            background: white;
            padding: 2.5rem 3rem;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgb(0 0 0 / 0.1);
        }
        h2 {
            text-align: center;
            color: #2a9d8f;
            margin-bottom: 2rem;
            letter-spacing: 1.2px;
        }
        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 0.6rem 1rem;
            margin-bottom: 1.5rem;
            border: 1.8px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }
        form textarea {
            resize: vertical;
            min-height: 100px;
        }
        form input:focus,
        form textarea:focus {
            border-color: #2a9d8f;
            outline: none;
        }
        button {
            display: block;
            width: 100%;
            background-color: #2a9d8f;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1b5f49;
        }
        .message {
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
        }
        .error {
            background-color: #e63946;
            color: white;
        }
        .success {
            background-color: #52b788;
            color: white;
        }
        footer {
            text-align: center;
            padding: 1.2rem 0;
            margin-top: 3rem;
            color: #555;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
<header>Pesona Sumut - Admin Dashboard</header>
<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="paket_wisata.php" class="active">Paket Wisata</a>
    <a href="pemesanan.php">Pemesanan</a>
</nav>
<main>
    <h2>Tambah Paket Wisata Baru</h2>

    <?php if ($success): ?>
        <div class="message success">Paket wisata berhasil ditambahkan. <a href="paket_wisata.php" style="color:#d5f5e3; text-decoration: underline;">Lihat daftar paket</a></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="message error">
            <ul style="list-style: none; padding-left: 0;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <label for="nama">Nama Paket Wisata</label>
        <input type="text" name="nama" id="nama" required value="<?= isset($nama) ? htmlspecialchars($nama) : '' ?>">

        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" required><?= isset($deskripsi) ? htmlspecialchars($deskripsi) : '' ?></textarea>

        <label for="gambar">Upload Gambar <small>(jpg/jpeg/png/gif)</small></label>
        <input type="file" name="gambar" id="gambar" accept="image/*" required>

        <button type="submit">Tambah Paket Wisata</button>
    </form>
</main>
<footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>


