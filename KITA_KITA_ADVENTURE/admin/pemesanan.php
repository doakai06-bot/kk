<?php
// admin/pemesanan.php
require_once '../config/database.php';

// Ambil data pemesanan beserta nama user
$sql = "SELECT p.*, user_id AS nama_user 
        FROM bookings p
        LEFT JOIN users u ON p.user_id = u.id
        ORDER BY booking_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Pemesanan - Admin Pesona Sumut</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f4f7fa; color: #333; min-height: 100vh; }
        header { background-color: #005f73; color: white; padding: 1rem 2rem; text-align: center; font-weight: 700; font-size: 1.5rem; letter-spacing: 2px; }
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
        nav a:hover, nav a.active {
            background-color: #94d2bd;
            color: #005f73;
        }
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: #0a9396;
            text-align: center;
            letter-spacing: 1.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        }
        thead {
            background-color: #0a9396;
            color: white;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        tbody tr:hover {
            background-color: #f0f8f9;
        }
        .action-btn {
            padding: 0.3rem 0.7rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
            display: inline-block;
        }
        .edit-btn {
            background-color: #94d2bd;
            color: #005f73;
        }
        .edit-btn:hover {
            background-color: #76c7b7;
            color: #003d33;
        }
        .delete-btn {
            background-color: #ee6c4d;
            color: white;
        }
        .delete-btn:hover {
            background-color: #e4572e;
        }
        footer {
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
            color: #777;
            font-size: 0.9rem;
        }
        @media (max-width: 700px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            tr {
                margin-bottom: 1.5rem;
                background: white;
                padding: 1rem;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            }
            td {
                border: none;
                padding-left: 50%;
                position: relative;
            }
            td::before {
                position: absolute;
                left: 1rem;
                width: 45%;
                white-space: nowrap;
                font-weight: 700;
                color: #0a9396;
            }
            td:nth-of-type(1)::before { content: "ID"; }
            td:nth-of-type(2)::before { content: "Pemesan"; }
            td:nth-of-type(3)::before { content: "Waktu Pelaksanaan"; }
            td:nth-of-type(4)::before { content: "Jumlah Peserta"; }
            td:nth-of-type(5)::before { content: "Layanan"; }
            td:nth-of-type(6)::before { content: "Total Tagihan"; }
            td:nth-of-type(7)::before { content: "Tanggal Pemesanan"; }
            td:nth-of-type(8)::before { content: "Aksi"; }
        }
    </style>
</head>
<body>
    <header>Pesona Sumut - Admin Dashboard</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="paket_wisata.php">Paket Wisata</a>
        <a href="pemesanan.php" class="active">Pemesanan</a>
    </nav>
    <main>
        <h2>Kelola Data Pemesanan</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pemesan</th>
                    <th>Waktu Pelaksanaan</th>
                    <th>Jumlah Peserta</th>
                    <th>Layanan</th>
                    <th>Total Tagihan (Rp)</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($p = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['customer_name'] ?: $p['nama_user']) ?></td>
                            <td><?= $p['booking_date'] ?> hari</td>
                            <td><?= $p['participants'] ?></td>
                            <td>
                                <?php 
                                $layanan = [];
                                if ($p['accommodation']) $layanan[] = "accommodation";
                                if ($p['transportation']) $layanan[] = "Transportasi";
                                if ($p['meals']) $layanan[] = "Makanan";
                                echo $layanan ? implode(", ", $layanan) : "-";
                                ?>
                            </td>
                            <td><?= number_format($p['package_price'], 0, ',', '.') ?></td>
                            <td><?= date('d M Y H:i', strtotime($p['booking_date'])) ?></td>
                            <td>
                                <a href="edit_pemesanan.php?id=<?= $p['id'] ?>" class="action-btn edit-btn">Edit</a>
                                <a href="delete.php?type=pemesanan&id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus pemesanan ini?')" class="action-btn delete-btn">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data pemesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>
