<?php
// cetak_struk.php
require_once 'config/database.php';
include 'includes/header.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$pemesanan_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM bookings WHERE id = $pemesanan_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan.";
    exit();
}

$pemesanan = mysqli_fetch_assoc($result);
?>

<style>
    body {
        background-color: #f0f0f0;
    }
    @media print {
        body {
            background: #fff !important;
        }
        .no-print, header, footer, nav, .navbar, .site-footer {
            display: none !important;
        }
        .struk-container {
            box-shadow: none;
            border: none;
            margin: 0;
            width: 100%;
        }
    }

    .struk-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }
    .struk-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .struk-header img {
        width: 100px;
        margin-bottom: 1rem;
    }
    .struk-header h3 {
        margin-bottom: 0;
        font-size: 24px;
    }
    .struk-header p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
    .struk-body table {
        width: 100%;
        font-size: 16px;
    }
    .struk-body td {
        padding: 8px 0;
    }
    .struk-total {
        font-weight: bold;
        border-top: 2px solid #000;
        padding-top: 10px;
        margin-top: 10px;
    }
    .struk-footer {
        text-align: center;
        margin-top: 2rem;
        font-style: italic;
        color: #888;
    }
</style>

<div class="struk-container">
    <div class="struk-header">
        <img src="assets/img/logo2.png" alt="Logo Pesona Sumut"> <!-- Ganti dengan logo kamu -->
        <h3>Struk Pemesanan</h3>
        <p><?php echo date('d M Y, H:i'); ?></p>
    </div>

    <div class="struk-body">
        <table>
            <tr>
                <td>Nama Pemesan</td>
                <td>: <?php echo htmlspecialchars($pemesanan['user_id']); ?></td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>: <?php echo htmlspecialchars($pemesanan['phone']); ?></td>
            </tr>
            <tr>
                <td>Jumlah Peserta</td>
                <td>: <?php echo $pemesanan['participants']; ?></td>
            </tr>
            <tr>
                <td>Penginapan</td>
                <td>: <?php echo $pemesanan['accommodation'] ? 'Rp ' . number_format(1000000, 0, ',', '.') : '-'; ?></td>
            </tr>
            <tr>
                <td>Transportasi</td>
                <td>: <?php echo $pemesanan['transportation'] ? 'Rp ' . number_format(1200000, 0, ',', '.') : '-'; ?></td>
            </tr>
            <tr>
                <td>Makanan</td>
                <td>: <?php echo $pemesanan['meals'] ? 'Rp ' . number_format(500000, 0, ',', '.') : '-'; ?></td>
            </tr>
            <tr class="struk-total">
                <td>Harga Paket / orang / hari</td>
                <td>: Rp <?php echo number_format($pemesanan['package_price'], 0, ',', '.'); ?></td>
            </tr>
            <tr class="struk-total">
                <td>Total Tagihan</td>
                <td>: Rp <?php echo number_format($pemesanan['total_amount'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="struk-footer">
        --- Terima kasih telah memesan bersama Kita Kita Adventure ---
    </div>
</div>

<script>
    window.print();
</script>

<?php include 'includes/footer.php'; ?>