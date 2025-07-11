<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$shop_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$conn->query("DELETE FROM shops WHERE shop_id = $shop_id AND owner_id = $user_id");
header("Location: manage_shops.php");
exit;
