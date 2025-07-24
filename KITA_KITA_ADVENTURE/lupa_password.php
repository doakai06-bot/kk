<?php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Cek apakah email ada
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Email ditemukan
        $new_password_plain = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 8); // 8 karakter random
        $new_password_hashed = password_hash($new_password_plain, PASSWORD_DEFAULT);

        // Update password
        $update_query = "UPDATE users SET password = '$new_password_hashed' WHERE email = '$email'";
        if (mysqli_query($conn, $update_query)) {
            // Kirim password baru (sementara pakai tampilan saja, belum kirim email asli)
            $message = '<div class="alert alert-success">Password baru kamu: <strong>' . $new_password_plain . '</strong><br>Segera login dan ubah password-mu!</div>';
        } else {
            $message = '<div class="alert alert-danger">Gagal memperbarui password. Coba lagi nanti.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Email tidak ditemukan!</div>';
    }
}
?>

<div class="container">
    <div class="auth-container">
        <div class="form-container">
            <h2 class="text-center mb-4">Lupa Password</h2>

            <?php echo $message; ?>

            <form method="POST" action="lupa_password.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Masukkan Email Anda</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                </div>
            </form>

            <div class="text-center mt-3">
                Ingat password? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
