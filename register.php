<?php
include "koneksi.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $role     = "user";

    // Validasi panjang password
    if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } elseif ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        // Cek username ganda
        $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan.";
        } else {
            // Simpan akun baru
            $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: dashboard.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Daftar Akun</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container-box">
  <h2 class="text-center mb-4">Daftar Akun</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Username:</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password:</label>
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" required>
        <span class="input-group-text">
          <i class="fa-solid fa-eye" id="toggleEye" onclick="togglePassword()" style="cursor:pointer;"></i>
        </span>
      </div>
    </div>
    <div class="mb-3">
      <label>Konfirmasi Password:</label>
      <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Daftar</button>
  </form>
  <div class="text-login">
    Sudah punya akun? <a href="index.php">Login di sini</a>
  </div>
</div>

<script>
function togglePassword() {
  const input = document.getElementById("password");
  const icon = document.getElementById("toggleEye");
  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  } else {
    input.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  }
}
</script>
</body>
</html>