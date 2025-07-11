<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $role;
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Shop Portal</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: url('https://images.unsplash.com/photo-1503264116251-35a269479413?auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .login-container {
            max-width: 420px;
            width: 100%;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                transform: translateY(-20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            color: white;
            font-size: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .input-group-icon {
            position: relative;
        }

        .input-group-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 10;
        }

        .input-group-icon .form-control {
            padding-left: 45px;
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #e9ecef;
        }

        .login-footer a {
            color: #ffffff;
            font-weight: 500;
            text-decoration: underline;
        }

        .alert-danger {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            background-color: rgba(220, 53, 69, 0.85);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-store-alt"></i>
                </div>
                <h2>Welcome Back</h2>
                <p>Sign in to your account</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <div class="input-group-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="Email address" required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </div>

                <div class="login-footer">
                    This is for Admin only.
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
