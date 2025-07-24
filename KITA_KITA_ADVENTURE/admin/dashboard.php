<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
// admin/dashboard.php
// Tanpa login (no session check)
// Contoh data ringkasan statis, bisa diganti dengan query ke DB

$total_users = 120;
$total_paket = 8;
$total_pemesanan = 53;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Pesona Sumut</title>
    <style>
        /* Reset dasar */
        * {
            box-sizing: border-box;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: #f4f7fa;
            color: #333;
            min-height: 100vh;
        }
        header {
            background-color: #005f73;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 2px;
        }
        nav {
            background: #0a9396;
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1rem 0;
            font-weight: 600;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #94d2bd;
            color: #005f73;
        }
        main {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: #0a9396;
            text-align: center;
            letter-spacing: 1.5px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
            gap: 1.5rem;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: default;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
        }
        .card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.3rem;
            color: #005f73;
        }
        .card p {
            font-size: 1.1rem;
            color: #555;
        }
        footer {
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
            color: #777;
            font-size: 0.9rem;
        }
        @media (max-width: 480px) {
            nav {
                flex-direction: column;
                gap: 1rem;
            }
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
        <h2>Ringkasan Data</h2>
        <div class="cards">
            <div class="card">
                <h3><?= $total_users ?></h3>
                <p>Total Pengguna</p>
            </div>
            <div class="card">
                <h3><?= $total_paket ?></h3>
                <p>Total Paket Wisata</p>
            </div>
            <div class="card">
                <h3><?= $total_pemesanan ?></h3>
                <p>Total Pemesanan</p>
            </div>
        </div>
    </main>
    <footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>
