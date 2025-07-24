<?php
// edit_pemesanan.php
require_once 'config/database.php';
include 'includes/header.php';

// Cek jika user belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$pemesanan_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

// Cek apakah pemesanan ada dan milik user yang login
$check_query = "SELECT * FROM pemesanan WHERE id = $pemesanan_id AND user_id = $user_id";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    header('Location: dashboard.php');
    exit();
}

$pemesanan = mysqli_fetch_assoc($check_result);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $waktu_pelaksanaan = (int)$_POST['waktu_pelaksanaan'];
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    $paket_wisata = mysqli_real_escape_string($conn, $_POST['paket_wisata']);
    $penginapan = isset($_POST['penginapan']) ? 1 : 0;
    $transportasi = isset($_POST['transportasi']) ? 1 : 0;
    $makanan = isset($_POST['makanan']) ? 1 : 0;

    // Harga layanan berdasarkan paket
    $harga_penginapan = 0;
    $harga_transportasi = 0;
    $harga_makanan = 0;

    switch ($paket_wisata) {
        case 'Danau Toba':
            $harga_penginapan = 1000000;
            $harga_transportasi = 1200000;
            $harga_makanan = 500000;
            break;
        case 'Bukit Lawang':
            $harga_penginapan = 800000;
            $harga_transportasi = 1000000;
            $harga_makanan = 400000;
            break;
        case 'Berastagi':
            $harga_penginapan = 900000;
            $harga_transportasi = 1100000;
            $harga_makanan = 450000;
            break;
    }

    $harga_paket = 0;
    if ($penginapan) $harga_paket += $harga_penginapan;
    if ($transportasi) $harga_paket += $harga_transportasi;
    if ($makanan) $harga_paket += $harga_makanan;

    $jumlah_tagihan = $waktu_pelaksanaan * $jumlah_peserta * $harga_paket;

    $query = "UPDATE pemesanan SET 
              nama_pemesan = '$nama_pemesan', 
              no_telp = '$no_telp', 
              waktu_pelaksanaan = $waktu_pelaksanaan, 
              jumlah_peserta = $jumlah_peserta, 
              paket_wisata = '$paket_wisata',
              penginapan = $penginapan, 
              transportasi = $transportasi, 
              makanan = $makanan, 
              harga_paket = $harga_paket, 
              jumlah_tagihan = $jumlah_tagihan
              WHERE id = $pemesanan_id AND user_id = $user_id";

    if (mysqli_query($conn, $query)) {
        $message = '<div class="alert alert-success">Pemesanan berhasil diperbarui.</div>';
        $check_result = mysqli_query($conn, $check_query);
        $pemesanan = mysqli_fetch_assoc($check_result);
    } else {
        $message = '<div class="alert alert-danger">Gagal memperbarui pemesanan: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<div class="container">
    <div class="row mb-5">
        <div class="col-lg-12">
            <h2 class="text-center my-4">Edit Pemesanan</h2>
            <?php echo $message; ?>
            <div class="form-container">
                <form id="form_pemesanan" method="POST" action="edit_pemesanan.php?id=<?php echo $pemesanan_id; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?php echo $pemesanan['nama_pemesan']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telp" class="form-label">Nomor Telepon/HP</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $pemesanan['no_telp']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="paket_wisata" class="form-label">Paket Wisata</label>
                        <select class="form-select" id="paket_wisata" name="paket_wisata" required>
                            <option value="Danau Toba" <?php if ($pemesanan['paket_wisata'] == 'Danau Toba') echo 'selected'; ?>>Danau Toba</option>
                            <option value="Bukit Lawang" <?php if ($pemesanan['paket_wisata'] == 'Bukit Lawang') echo 'selected'; ?>>Bukit Lawang</option>
                            <option value="Berastagi" <?php if ($pemesanan['paket_wisata'] == 'Berastagi') echo 'selected'; ?>>Berastagi</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="waktu_pelaksanaan" class="form-label">Waktu Pelaksanaan Perjalanan (hari)</label>
                            <input type="number" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" min="1" value="<?php echo $pemesanan['waktu_pelaksanaan']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                            <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" min="1" value="<?php echo $pemesanan['jumlah_peserta']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pelayanan Paket Perjalanan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="penginapan" name="penginapan" value="1" <?php echo $pemesanan['penginapan'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="penginapan">Penginapan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="transportasi" name="transportasi" value="1" <?php echo $pemesanan['transportasi'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="transportasi">Transportasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="makanan" name="makanan" value="1" <?php echo $pemesanan['makanan'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="makanan">Makanan</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="harga_paket" class="form-label">Harga Paket Perjalanan</label>
                            <input type="text" class="form-control" id="harga_paket" value="<?php echo $pemesanan['harga_paket']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_tagihan" class="form-label">Jumlah Tagihan</label>
                            <input type="text" class="form-control" id="jumlah_tagihan" value="<?php echo $pemesanan['jumlah_tagihan']; ?>" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="dashboard.php" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui Pemesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
