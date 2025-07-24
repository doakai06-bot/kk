<?php
// index.php
require_once 'config/database.php';

// Ambil data paket wisata dari database
$query = "SELECT * FROM paket_wisata";
$result = mysqli_query($conn, $query);
$paket_wisata = mysqli_fetch_all($result, MYSQLI_ASSOC);

include 'includes/header.php';
?>

<div class="hero-section">
    <div class="container text-center">
        <h1>Jelajahi Keindahan Sumatera Utara</h1>
        <p class="lead">Temukan pesona alam, budaya, dan kuliner Sumatera Utara bersama kami</p>
        <a href="paket_wisata.php" class="btn btn-light btn-lg mt-3">Lihat Paket Wisata</a>
    </div>n
</div>

<div class="container">
    <section class="mb-5">
        <h2 class="text-center mb-4">Paket Wisata Pilihan</h2>
        <div class="row">
            <?php foreach($paket_wisata as $paket): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="assets/img/<?php echo $paket['gambar']; ?>" class="card-img-top" alt="<?php echo $paket['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $paket['nama']; ?></h5>
                        <p class="card-text"><?php echo $paket['deskripsi']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="pemesanan.php?paket=<?php echo $paket['id']; ?>" class="btn btn-primary">Pesan Sekarang</a>
                           
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <section class="mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Kenapa Memilih Pesona Sumut?</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Pengalaman perjalanan yang tak terlupakan
                    </li>
                    <li class="list-group-item bg-transparent">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Pemandu wisata lokal yang berpengalaman
                    </li>
                    <li class="list-group-item bg-transparent">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Destinasi wisata terbaik di Sumatera Utara
                    </li>
                    <li class="list-group-item bg-transparent">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Kualitas pelayanan yang terjamin
                    </li>
                    <li class="list-group-item bg-transparent">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Harga terjangkau dengan fasilitas lengkap
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="ratio ratio-16x9">
                </div>
            </div>
        </div>
    </section>
    
    <section class="mb-5">
        <h2 class="text-center mb-4">Testimoni Pelanggan</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Pengalaman liburan yang sangat memuaskan. Pemandu wisata sangat ramah dan informatif. Destinasi yang dikunjungi sangat indah!"</p>
                        <p class="fw-bold mb-0">- Budi Santoso</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Danau Toba sungguh memukau! Semua akomodasi dan transportasi diatur dengan sangat baik. Akan kembali lagi!"</p>
                        <p class="fw-bold mb-0">- Siti Aminah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="card-text">"Paket wisata yang sangat worth it! Pelayanan memuaskan, makanan lezat, dan pemandangan yang luar biasa."</p>
                        <p class="fw-bold mb-0">- Rini Wulandari</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
