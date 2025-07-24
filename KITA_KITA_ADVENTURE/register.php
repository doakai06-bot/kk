<?php
// register.php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    
    // Cek apakah email sudah digunakan
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $message = '<div class="alert alert-danger">Email sudah terdaftar. Silakan gunakan email lain.</div>';
    } else {
        $query = "INSERT INTO users (name, email, password, phone) VALUES ('$nama', '$email', '$password', '$no_telp')";
        
        if (mysqli_query($conn, $query)) {
            $message = '<div class="alert alert-success">Pendaftaran berhasil! Silakan <a href="login.php">login</a>.</div>';
        } else {
            $message = '<div class="alert alert-danger">Pendaftaran gagal: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>

<div class="container">
    <div class="auth-container">
        <div class="form-container">
            <h2 class="text-center mb-4">Daftar Akun</h2>
            
            <?php echo $message; ?>
            
            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>