<?php
// admin/users.php
require_once '../config/database.php';

// Ambil data users
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Pengguna - Admin Pesona Sumut</title>
    <style>
        /* Styling mirip dashboard */
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
        nav a:hover, nav a.active {
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
        .add-btn {
            display: inline-block;
            background-color: #005f73;
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1rem;
            transition: background-color 0.3s ease;
        }
        .add-btn:hover {
            background-color: #0a9396;
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
        }
        .edit-btn {
            background-color: #94d2bd;
            color: #005f73;
        }
        .edit-btn:hover {
            background-color: #76c7b7;
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
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
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
            td:nth-of-type(2)::before { content: "Nama"; }
            td:nth-of-type(3)::before { content: "Email"; }
            td:nth-of-type(4)::before { content: "No Telp"; }
            td:nth-of-type(5)::before { content: "Dibuat"; }
            td:nth-of-type(6)::before { content: "Aksi"; }
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
        <h2>Kelola Pengguna</h2>

        <a href="add_user.php" class="add-btn">+ Tambah Pengguna</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="action-btn edit-btn">Edit</a>
                                <a href="delete.php?type=user&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus pengguna ini?')" 
                                   class="action-btn delete-btn">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">Data pengguna belum tersedia.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>© 2025 Pesona Sumut. All rights reserved.</footer>
</body>
</html>
