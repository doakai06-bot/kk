<?php
// admin/delete.php
require_once '../config/database.php';

// Validasi parameter GET
if (!isset($_GET['type']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Permintaan tidak valid.");
}

$type = $_GET['type'];
$id = (int)$_GET['id'];

switch ($type) {
    case 'user':
        $table = 'users';
        $redirect = 'users.php';
        break;
    case 'paket':
        $table = 'paket_wisata';
        $redirect = 'paket_wisata.php';
        break;
    case 'pemesanan':
        $table = 'bookings';
        $redirect = 'pemesanan.php';
        break;
    default:
        die("Tipe data tidak dikenali.");
}

// Eksekusi query penghapusan
$sql = "DELETE FROM $table WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Redirect kembali ke halaman terkait
if ($result) {
    header("Location: $redirect?msg=deleted");
    exit;
} else {
    die("Gagal menghapus data.");
}
