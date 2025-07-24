<?php
// login.php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
            header('Location: dashboard.php');
            }
            exit();
        } else {
            $message = '<div class="alert alert-danger">Password salah. Silakan coba lagi.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Email tidak ditemukan. Silakan daftar terlebih dahulu.</div>';
    }
}
?>

<div class="container">
    <div class="auth-container">
        <div class="form-container">
            <h2 class="text-center mb-4">Login</h2>
            
            <?php echo $message; ?>
            
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small><a href="lupa_password.php">Lupa Password?</a></small>
            </div>
            <div class="text-center mt-2">
                <small>Belum punya akun? <a href="register.php">Daftar di sini</a></small>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
