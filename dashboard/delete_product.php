<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE product_id = $id");
header("Location: products.php");
exit;
