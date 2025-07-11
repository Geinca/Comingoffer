<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM offers WHERE offer_id = $id");
header("Location: offers.php");
exit;
