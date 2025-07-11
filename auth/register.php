<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role     = 'shop_owner';

    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_role'] = $role;
            header("Location: login.php");
            exit();
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<!-- HTML Part -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Shop Owner Registration</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
        <button type="submit" class="btn btn-primary">Register</button>
        <p class="mt-3">Already registered? <a href="login.php">Login here</a></p>
    </form>
</div>
</body>
</html>
