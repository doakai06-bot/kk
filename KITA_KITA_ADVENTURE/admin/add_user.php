<?php
// admin/add_user.php
require_once '../config/database.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $no_telp = trim($_POST['no_telp']);

    // Validasi sederhana
    if (!$nama) {
        $errors[] = "Nama harus diisi.";
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    if (!$password || strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }

    // Cek email sudah terdaftar
    $cekEmail = mysqli_query($conn, "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "' LIMIT 1");
    if (mysqli_num_rows($cekEmail) > 0) {
        $errors[] = "Email sudah terdaftar.";
    }

    if (empty($errors)) {
        // Hash password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nama, email, password, no_telp) VALUES (
            '" . mysqli_real_escape_string($conn, $nama) . "',
            '" . mysqli_real_escape_string($conn, $email) . "',
            '" . $hashPassword . "',
            '" . mysqli_real_escape_string($conn, $no_telp) . "'
        )";

        if (mysqli_query($conn, $sql)) {
            $success = true;
        } else {
            $errors[] = "Gagal menambahkan user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah User - Admin Pesona Sumut</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fa;
            margin: 0; padding: 0;
        }
        header {
            background-color: #005f73;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 2px;
        }
        nav {
            background: #0a9396;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 1rem 0;
            font-weight: 600;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #94d2bd;
            color: #005f73;
        }
        main {
            max-width: 480px;
            margin: 2.5rem auto;
            background: white;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
        }
        h2 {
            text-align: center;
            color: #0a9396;
            margin-bottom: 1.5rem;
            letter-spacing: 1.3px;
        }
        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #333;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="tel"] {
            width: 100%;
            padding: 0.5rem 0.8rem;
            margin-bottom: 1.2rem;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus,
        form input[type="tel"]:focus {
            border-color: #0a9396;
            outline: none;
        }
        button {
            display: block;
            width: 100%;
            background-color: #0a9396;
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005f73;
        }
        .message {
            padding: 0.8rem 1rem;
            margin-bottom: 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }
        .error {
            background-color: #ee6c4d;
            color: white;
        }
        .success {
            background-color: #2a9d8f;
            color: white;
        }
        footer {
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<header>Pesona Sumut - Admin Dashboard</header>
<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="users.php" class="active">Users</a>
    <a href="paket_wisata.php">Paket Wisata</a>
    <a href="pemesanan.php">Pemesanan</a>
</nav>
<main>
    <h2>Tambah User Baru</h2>

    <?php if ($success): ?>
        <div class="message success">User berhasil ditambahkan. <a href="users.php" style="color:#d1e8e2; text-decoration: underline;">Lihat daftar user</a></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="message error">
            <ul style="list-style: none; padding-left: 0;">
                <?php foreach($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST" novalidate>
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" required value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="no_telp">No. Telepon</label>
        <input type="tel" name="no_telp" id="no_telp" value="<?= isset($_POST['no_telp']) ? htmlspecialchars($_POST['no_telp']) : '' ?>">

        <button type="submit">Tambah User</button>
    </form>
</main>
<footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>

