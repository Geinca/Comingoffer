<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name']    ?? '';
    $email   = $_POST['email']   ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($subject)) $errors[] = 'Subject is required';
    if (empty($message)) $errors[] = 'Message is required';

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO customer_queries
             (user_id, name, email, subject, message)
             VALUES (?, ?, ?, ?, ?)"
        );
        $user_id = $_SESSION['user_id'] ?? null;
        $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);
        $stmt->execute();
        http_response_code(200);
        echo 'success';
    } else {
        http_response_code(422);
        echo implode(', ', $errors); // Shows all validation errors
    }
}
?>
