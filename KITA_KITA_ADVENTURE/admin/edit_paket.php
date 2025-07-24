<?php
// admin/edit_paket.php
require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID paket tidak valid.");
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM paket_wisata WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Data paket wisata tidak ditemukan.");
}

$paket = mysqli_fetch_assoc($result);
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = trim($_POST['gambar']);
    $video_url = trim($_POST['video_url']);

    if (!$nama) {
        $errors[] = "Nama paket wisata harus diisi.";
    }
    if (!$deskripsi) {
        $errors[] = "Deskripsi harus diisi.";
    }
    if ($video_url && !filter_var($video_url, FILTER_VALIDATE_URL)) {
        $errors[] = "URL video tidak valid.";
    }

    if (empty($errors)) {
        $sqlUpdate = "UPDATE paket_wisata SET
            nama = '" . mysqli_real_escape_string($conn, $nama) . "',
            deskripsi = '" . mysqli_real_escape_string($conn, $deskripsi) . "',
            gambar = '" . mysqli_real_escape_string($conn, $gambar) . "',
            video_url = '" . mysqli_real_escape_string($conn, $video_url) . "'
            WHERE id = $id";

        if (mysqli_query($conn, $sqlUpdate)) {
            $success = true;
            $paket = ['nama' => $nama, 'deskripsi' => $deskripsi, 'gambar' => $gambar, 'video_url' => $video_url];
        } else {
            $errors[] = "Gagal menyimpan perubahan: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Paket Wisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafc;
            margin: 0;
            padding: 0;
        }
        header {
            background: #007f5f;
            padding: 1.5rem;
            color: #fff;
            text-align: center;
            font-size: 1.8rem;
        }
        nav {
            background: #2a9d8f;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 1rem 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        nav a:hover {
            background: #74c69d;
        }
        main {
            max-width: 540px;
            margin: 2.5rem auto;
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #2a9d8f;
            margin-bottom: 2rem;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            margin-bottom: 1.5rem;
            border: 1.8px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
        }
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        input:focus,
        textarea:focus {
            border-color: #2a9d8f;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #2a9d8f;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #1b5f49;
        }
        .message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            text-align: center;
        }
        .error { background-color: #e63946; color: white; }
        .success { background-color: #52b788; color: white; }
        footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
<header>Pesona Sumut - Admin Dashboard</header>
<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="paket_wisata.php">Paket Wisata</a>
    <a href="pemesanan.php">Pemesanan</a>
</nav>

<main>
    <h2>Edit Paket Wisata</h2>

    <?php if ($success): ?>
        <div class="message success">Perubahan berhasil disimpan. <a href="paket_wisata.php" style="color: #d5f5e3;">Kembali ke daftar</a></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="message error">
            <?php foreach ($errors as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="nama">Nama Paket Wisata</label>
        <input type="text" name="nama" id="nama" required value="<?= htmlspecialchars($paket['nama']) ?>">

        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" required><?= htmlspecialchars($paket['deskripsi']) ?></textarea>

        <label for="gambar">Nama File Gambar</label>
        <input type="text" name="gambar" id="gambar" required value="<?= htmlspecialchars($paket['gambar']) ?>">

        <label for="video_url">URL Video (Opsional)</label>
        <input type="text" name="video_url" id="video_url" value="<?= htmlspecialchars($paket['video_url']) ?>">

        <button type="submit">Simpan Perubahan</button>
    </form>
</main>

<footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>
