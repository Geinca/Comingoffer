<?php
session_start();
require_once '../config/db.php';

$adminOnly = false;            // ← set true if this page is for admins ONLY

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password']    ?? '';

    /* ---------- lookup user ---------- */
    $sql  = 'SELECT user_id, name, password, role FROM users WHERE email = ? LIMIT 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $name, $hash, $role);

    if ($stmt->fetch() && password_verify($password, $hash)) {

        /* ---------- optional admin‑only gate ---------- */
        if ($adminOnly && $role !== 'admin') {
            $error = 'This login page is for admins only.';
        } else {
            $_SESSION['user_id']   = $user_id;
            $_SESSION['username']  = $name;
            $_SESSION['role']      = $role;

            /* ---------- smart redirect ---------- */
            switch ($role) {
                case 'admin':
                    header('Location: ../admin/index.php');
                    break;
                case 'shop_owner':
                default:
                    header('Location: ../dashboard/index.php');
            }
            exit;
        }
    } else {
        $error = 'Invalid email or password.';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login – Shop Portal</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/login.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="login-container">
    <div class="login-header text-center">
      <i class="fas fa-store-alt fa-2x mb-3"></i>
      <h2 class="fw-bold">Welcome Back</h2>
      <p class="text-muted">Sign in to your account</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
      <div class="mb-3 position-relative">
        <i class="fas fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input type="email" name="email" class="form-control ps-5" placeholder="Email address" required>
      </div>

      <div class="mb-3 position-relative">
        <i class="fas fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input type="password" name="password" class="form-control ps-5" placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
        <i class="fas fa-sign-in-alt me-2"></i> Login
      </button>

      <?php if ($adminOnly): ?>
        <div class="text-center mt-3 small text-muted">This login is for <strong>Admin</strong> only.</div>
      <?php endif; ?>
    </form>
  </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
