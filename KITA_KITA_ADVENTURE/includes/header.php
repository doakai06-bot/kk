<?php
// includes/header.php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kita Kita Adventure - Wisata Nusantara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/img/logo5.png" alt="Logo Pesona Sumut" width="30" height="30" class="me-2">
               Kita Kita Adventure
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="index.php">Beranda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="paket_wisata.php">Paket Wisata</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="pemesanan.php">Pemesanan</a>
    </li>

    <!-- ⬇️ Tambahan dropdown Artikel -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="artikelDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Artikel
        </a>
        <ul class="dropdown-menu" aria-labelledby="artikelDropdown">
            <li><a class="dropdown-item" href="artikel.php">Semua Artikel</a></li>
            <li><a class="dropdown-item" href="artikel.php?kategori=wisata">Wisata</a></li>
            <li><a class="dropdown-item" href="artikel.php?kategori=budaya">Budaya</a></li>
        </ul>
    </li>
    <!-- ⬆️ End Dropdown Artikel -->
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i><?php echo $_SESSION['nama']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Daftar</a>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
