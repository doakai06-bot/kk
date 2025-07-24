<?php
session_start();
include 'config/database.php'; // Pastikan koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Proses jika form disubmit
if (isset($_POST['ubah_password'])) {
    $password_lama = mysqli_real_escape_string($conn, $_POST['password_lama']);
    $password_baru = mysqli_real_escape_string($conn, $_POST['password_baru']);
    $konfirmasi_password = mysqli_real_escape_string($conn, $_POST['konfirmasi_password']);

    // Ambil password lama dari database
    $query = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'");
    $data = mysqli_fetch_assoc($query);

    if (password_verify($password_lama, $data['password'])) {
        // Password lama cocok
        if ($password_baru === $konfirmasi_password) {
            $password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            $update = mysqli_query($conn, "UPDATE users SET password='$password_baru_hash' WHERE id='$user_id'");

            if ($update) {
                header('Location: dashboard.php?status=password_updated');
                exit();
            } else {
                $error = "Gagal memperbarui password. Silakan coba lagi.";
            }
        } else {
            $error = "Password baru dan konfirmasi tidak cocok.";
        }
    } else {
        $error = "Password lama salah.";
    }
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Ganti Password</h3>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Password Lama</label>
                        <input type="password" name="password_lama" id="password_lama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="ubah_password" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="dashboard.php" class="text-decoration-none">← Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
