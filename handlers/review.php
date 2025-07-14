<?php
require_once '../config/db.php';  

header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'msg' => 'Bad method']); exit;
}

$shopId  = (int)($_POST['shop_id']  ?? 0);
$rating  = (int)($_POST['rating']   ?? 0);
$comment = trim($_POST['comment']   ?? '');

if ($shopId && $rating >=1 && $rating <=5) {
  $stmt = $conn->prepare('INSERT INTO reviews (shop_id, user_id, rating, comment)
                          VALUES (?,?,?,?)');
  $stmt->bind_param('iiis', $shopId, $_SESSION['user_id'], $rating, $comment);
  $ok = $stmt->execute();
  $stmt->close();
  echo json_encode(['success' => $ok]);
} else {
  echo json_encode(['success' => false, 'msg' => 'Invalid input']);
}
?>
