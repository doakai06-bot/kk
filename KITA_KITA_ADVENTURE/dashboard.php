<?php
// dashboard.php
require_once 'config/database.php';
include 'includes/header.php';

// Validasi user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data pemesanan user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY travel_date DESC";
$result = mysqli_query($conn, $query);
$pemesanan = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Hapus pemesanan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM pemesanan WHERE id = $id AND user_id = $user_id";
    
    if (mysqli_query($conn, $delete_query)) {
        header('Location: dashboard.php?status=deleted');
        exit();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                <h2>Dashboard</h2>
                <a href="pemesanan.php" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Buat Pemesanan Baru
                </a>
            </div>
            
            <?php if(isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
                <div class="alert alert-success">Pemesanan berhasil dihapus.</div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Riwayat Pemesanan</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($pemesanan)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <p class="lead">Anda belum memiliki pemesanan.</p>
                            <a href="pemesanan.php" class="btn btn-primary mt-2">Buat Pemesanan Sekarang</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pemesanan</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pemesan</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Waktu Pelaksanaan</th>
                                        <th>Total Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pemesanan as $item): ?>
                                        <tr>
                                            <td>#<?php echo $item['id']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($item['tanggal_pemesanan'])); ?></td>
                                            <td><?php echo $item['nama_pemesan']; ?></td>
                                            <td><?php echo $item['jumlah_peserta']; ?> orang</td>
                                            <td><?php echo $item['waktu_pelaksanaan']; ?> hari</td>
                                            <td>Rp <?php echo number_format($item['jumlah_tagihan'], 0, ',', '.'); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="edit_pemesanan.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="cetak_struk.php?id=<?php echo $item['id']; ?>" class="btn btn-info">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="dashboard.php?delete=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus pemesanan ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>