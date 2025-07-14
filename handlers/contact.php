<?php

session_start();
require_once '../config/db.php';   // your mysqli $conn

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Only POST allowed.');
}

/* ------------------------------------------------------------------ */
/* 1. Validate input                                                  */
/* ------------------------------------------------------------------ */
$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];
if ($name === '')                         $errors[] = 'Name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                                           $errors[] = 'Valid email required.';
if ($subject === '')                      $errors[] = 'Subject is required.';
if ($message === '')                      $errors[] = 'Message is required.';

if ($errors) {
    http_response_code(422);
    exit(implode(' ', $errors));
}

/* ------------------------------------------------------------------ */
/* 2. Save to database                                                */
/* ------------------------------------------------------------------ */
$user_id = $_SESSION['user_id'] ?? null;

try {
    $stmt = $conn->prepare(
        "INSERT INTO customer_queries (user_id, name, email, subject, message)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('DB error: ' . $e->getMessage());
}

/* ------------------------------------------------------------------ */
/* 3. Send email using mail()                                         */
/* ------------------------------------------------------------------ */
// Where you (or support) will receive the enquiry
$adminEmail = ' info@comingoffer.com';

/**
 * Very important:
 *   • Use an address on your own domain in "From" to avoid SPF/DKIM failures.
 *   • Put visitor’s address in Reply‑To so you can hit Reply.
 */
$from      = 'info@comingoffer.com';
$replyTo   = $email;
$cleanSubj = preg_replace("/[\r\n]+/", '', $subject);  // header‑injection guard

$emailBody  = "You have a new enquiry:\n\n";
$emailBody .= "Name   : $name\n";
$emailBody .= "Email  : $email\n";
$emailBody .= "Subject: $subject\n\n";
$emailBody .= "Message:\n$message\n";

$headers  = "From: $from\r\n";
$headers .= "Reply-To: $replyTo\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($adminEmail, "Contact‑Us: $cleanSubj", $emailBody, $headers)) {
    http_response_code(200);
    echo 'success';
} else {
    // record saved, but mail() failed
    http_response_code(202);
    echo 'Saved, but email could not be sent (check server mail configuration).';
}
