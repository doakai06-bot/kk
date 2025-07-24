<?php
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'pemesanan.php';
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['phone']);
    $waktu_pelaksanaan = (int)$_POST['waktu_pelaksanaan'];
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    $paket_wisata = mysqli_real_escape_string($conn, $_POST['paket_wisata']);
    $penginapan = isset($_POST['penginapan']) ? 1 : 0;
    $transportasi = isset($_POST['transportasi']) ? 1 : 0;
    $makanan = isset($_POST['makanan']) ? 1 : 0;

    // Harga berdasarkan paket
    $harga_penginapan = ['Danau Toba' => 1000000, 'Bukit Lawang' => 800000, 'Berastagi' => 900000];
    $harga_transportasi = ['Danau Toba' => 1200000, 'Bukit Lawang' => 1000000, 'Berastagi' => 1100000];
    $harga_makanan = ['Danau Toba' => 500000, 'Bukit Lawang' => 400000, 'Berastagi' => 450000];

    $harga_paket = 0;
    if ($penginapan) $harga_paket += $harga_penginapan[$paket_wisata];
    if ($transportasi) $harga_paket += $harga_transportasi[$paket_wisata];
    if ($makanan) $harga_paket += $harga_makanan[$paket_wisata];
    $jumlah_tagihan = $waktu_pelaksanaan * $jumlah_peserta * $harga_paket;

    $query = "INSERT INTO bookings (user_id, id, customer_name, phone, travel_date, participants, accommodation, transportation, meals, package_price, total_amount) 
          VALUES ($user_id, '$paket_wisata', '$nama_pemesan', '$no_telp', $waktu_pelaksanaan, $jumlah_peserta, $penginapan, $transportasi, $makanan, $harga_paket, $jumlah_tagihan)";
    
    if (mysqli_query($conn, $query)) {
        $pemesanan_id = mysqli_insert_id($conn);
        $success = true;
    }
}

$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
?>

<div class="container">
    <?php if ($success): ?>
        <div class="form-container my-5">
            <div class="text-center mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                <h2 class="mt-3">Pemesanan Berhasil!</h2>
                <p class="lead">Terima kasih telah memesan paket wisata di Pesona Sumut.</p>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">RANGKUMAN RESERVASI PAKET WISATA</h5>
                </div>
                <div class="card-body">
                    <?php
                    $pemesanan_query = "SELECT * FROM bookings WHERE id = $pemesanan_id";
                    $pemesanan_result = mysqli_query($conn, $pemesanan_query);
                    $pemesanan = mysqli_fetch_assoc($pemesanan_result);

                    $layanan = [];
                    if ($pemesanan['accommodation']) $layanan[] = 'accommodation';
                    if ($pemesanan['transportation']) $layanan[] = 'Transportation';
                    if ($pemesanan['meals']) $layanan[] = 'meals';
                    $layanan_str = implode(', ', $layanan);
                    ?>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Nama</div>
                        <div class="col-md-8"><?php echo $pemesanan['user_id']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Paket Wisata</div>
                        <div class="col-md-8"><?php echo $pemesanan['customer_name']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Jumlah Peserta</div>
                        <div class="col-md-8"><?php echo $pemesanan['participants']; ?> orang</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Waktu Perjalanan</div>
                        <div class="col-md-8"><?php echo $pemesanan['booking_date']; ?> hari</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Layanan Paket</div>
                        <div class="col-md-8"><?php echo $layanan_str; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Harga Paket</div>
                        <div class="col-md-8">Rp <?php echo number_format($pemesanan['package_price'], 0, ',', '.'); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 fw-bold">Jumlah Tagihan</div>
                        <div class="col-md-8 fw-bold">Rp <?php echo number_format($pemesanan['total_amount'], 0, ',', '.'); ?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="cetak_struk.php?id=<?php echo $pemesanan_id; ?>" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Cetak Struk
                </a>
                <a href="pemesanan.php" class="btn btn-outline-primary">
                    <i class="fas fa-plus-circle me-2"></i>Pesan Lagi
                </a>
                <a href="dashboard.php" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-2"></i>Dashboard
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row mb-5">
            <div class="col-lg-12">
                <h2 class="text-center my-4">Pemesanan Paket Wisata</h2>
                <div class="form-container">
                    <form id="form_pemesanan" method="POST" action="pemesanan.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?php echo $user['name']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_telp" class="form-label">Nomor Telepon/HP</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="paket_wisata" class="form-label">Paket Wisata</label>
                            <select class="form-select" id="paket_wisata" name="paket_wisata" required>
                                <option value="Danau Toba">Danau Toba</option>
                                <option value="Bukit Lawang">Bukit Lawang</option>
                                <option value="Berastagi">Berastagi</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_pelaksanaan" class="form-label">Waktu Pelaksanaan Perjalanan (hari)</label>
                                <input type="number" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" min="1" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" min="1" value="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pelayanan Paket Perjalanan</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="penginapan" name="penginapan" value="1">
                                <label class="form-check-label" for="penginapan">Penginapan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="transportasi" name="transportasi" value="1">
                                <label class="form-check-label" for="transportasi">Transportasi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="makanan" name="makanan" value="1">
                                <label class="form-check-label" for="makanan">Makanan</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga_paket" class="form-label">Harga Paket Perjalanan</label>
                                <input type="text" class="form-control" id="harga_paket" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_tagihan" class="form-label">Jumlah Tagihan</label>
                                <input type="text" class="form-control" id="jumlah_tagihan" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="paket_wisata.php" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Pemesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
