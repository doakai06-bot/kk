<?php
// paket_wisata.php
require_once 'config/database.php';

// Ambil data paket wisata dari database
$query = "SELECT * FROM paket_wisata";
$result = mysqli_query($conn, $query);
$paket_wisata = mysqli_fetch_all($result, MYSQLI_ASSOC);

include 'includes/header.php';
?>

<div class="container">
    <div class="text-center my-5">
        <h1>Paket Wisata Pesona Sumut</h1>
        <p class="lead">Pilih destinasi wisata terbaik untuk perjalanan Anda di Sumatera Utara</p>
    </div>
    
    <div class="row">
        <?php foreach($paket_wisata as $paket): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <img src="assets/img/<?php echo $paket['gambar']; ?>" class="card-img-top" alt="<?php echo $paket['nama']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $paket['nama']; ?></h5>
                    <p class="card-text"><?php echo $paket['deskripsi']; ?></p>
                </div>
                <div class="card-footer d-flex justify-content-between bg-white">
                    <a href="pemesanan.php?paket=<?php echo $paket['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-1"></i> Pesan Sekarang
                    </a>
                    <a href="<?php echo $paket['video_url']; ?>" target="_blank" class="btn btn-outline-danger">
                        <i class="fab fa-youtube me-1"></i> Lihat Video
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pelayanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-bed me-2 text-primary"></i> Penginapan</h6>
                        <p>Hotel bintang 3 atau 4 dengan lokasi strategis dan fasilitas lengkap untuk kenyamanan Anda selama perjalanan.</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-bus me-2 text-primary"></i> Transportasi</h6>
                        <p>Transportasi nyaman dengan AC, termasuk penjemputan dan pengantaran dari/ke bandara atau stasiun.</p>
                    </div>
                    <div>
                        <h6><i class="fas fa-utensils me-2 text-primary"></i> Makanan</h6>
                        <p>3x makan sehari dengan menu lokal dan internasional yang lezat dan higienis.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Harga</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Penginapan
                            <span class="badge bg-primary rounded-pill">Rp 800.000 an</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Transportasi
                            <span class="badge bg-primary rounded-pill">Rp 1.000.000 an</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Makanan
                            <span class="badge bg-primary rounded-pill">Rp 500.000 an</span>
                        </li>
                    </ul>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Total harga akan dihitung berdasarkan jumlah peserta, lama waktu perjalanan, dan pelayanan yang dipilih.
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="pemesanan.php" class="btn btn-primary">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>