<?php
// admin/edit_pemesanan.php
require_once '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM pemesanan WHERE id = $id");
$pemesanan = mysqli_fetch_assoc($query);

if (!$pemesanan) {
    die("Data pemesanan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $no_telp = $_POST['no_telp'];
    $waktu_pelaksanaan = (int)$_POST['waktu_pelaksanaan'];
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    $penginapan = isset($_POST['penginapan']) ? 1 : 0;
    $transportasi = isset($_POST['transportasi']) ? 1 : 0;
    $makanan = isset($_POST['makanan']) ? 1 : 0;

    // Hitung ulang harga (contoh statis, bisa dibuat dinamis)
    $harga_per_peserta = 200000;
    $harga_tambahan = 0;
    if ($penginapan) $harga_tambahan += 50000;
    if ($transportasi) $harga_tambahan += 40000;
    if ($makanan) $harga_tambahan += 30000;

    $harga_paket = $harga_per_peserta + $harga_tambahan;
    $jumlah_tagihan = $harga_paket * $jumlah_peserta;

    $update = mysqli_query($conn, "UPDATE pemesanan SET 
        nama_pemesan='$nama_pemesan',
        no_telp='$no_telp',
        waktu_pelaksanaan=$waktu_pelaksanaan,
        jumlah_peserta=$jumlah_peserta,
        penginapan=$penginapan,
        transportasi=$transportasi,
        makanan=$makanan,
        harga_paket=$harga_paket,
        jumlah_tagihan=$jumlah_tagihan
        WHERE id=$id");

    if ($update) {
        header("Location: pemesanan.php?msg=updated");
        exit;
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center text-success">Edit Data Pemesanan</h2>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Nama Pemesan</label>
                <input type="text" name="nama_pemesan" class="form-control" value="<?= $pemesanan['nama_pemesan'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $pemesanan['no_telp'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Waktu Pelaksanaan (hari)</label>
                <input type="number" name="waktu_pelaksanaan" class="form-control" value="<?= $pemesanan['waktu_pelaksanaan'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" class="form-control" value="<?= $pemesanan['jumlah_peserta'] ?>" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="penginapan" <?= $pemesanan['penginapan'] ? 'checked' : '' ?>>
                <label class="form-check-label">Penginapan</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="transportasi" <?= $pemesanan['transportasi'] ? 'checked' : '' ?>>
                <label class="form-check-label">Transportasi</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="makanan" <?= $pemesanan['makanan'] ? 'checked' : '' ?>>
                <label class="form-check-label">Makanan</label>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="pemesanan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
