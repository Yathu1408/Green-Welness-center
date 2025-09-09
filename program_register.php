<?php
session_start();
require 'db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($pdo) && $pdo instanceof PDO) {
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}

$isAjax =
  (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest') ||
  (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

function jsonResponse($status, $message, $http = 200) {
  http_response_code($http);
  header('Content-Type: application/json; charset=utf-8');
  header('Cache-Control: no-store');
  if (ob_get_length()) { @ob_clean(); } // remove any prior output (warnings/BOM)
  echo json_encode(['status' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE);
  exit;
}

// Accept either session key (so you don’t have to change other pages)
$userId = $_SESSION['user_id'] ?? $_SESSION['customer_id'] ?? null;

if (!$userId) {
  if ($isAjax) jsonResponse('error', 'Not logged in', 401);
  header('Location: login.php'); exit;
}

$program_id = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);
if (!$program_id) {
  if ($isAjax) jsonResponse('error', 'Invalid program.', 400);
  die('Invalid program.');
}

try {
  // Prevent duplicates
  $stmt = $pdo->prepare('SELECT id FROM program_registrations WHERE user_id=? AND program_id=?');
  $stmt->execute([(int)$userId, $program_id]);
  if ($stmt->fetch()) {
    if ($isAjax) jsonResponse('info', 'You have already registered for this program.');
    die('You have already registered for this program.');
  }

  // Insert
  $stmt = $pdo->prepare('INSERT INTO program_registrations (user_id, program_id) VALUES (?, ?)');
  $stmt->execute([(int)$userId, $program_id]);

  if ($isAjax) jsonResponse('success', 'Registration successful!');
  echo "<script>alert('Registration successful!'); window.location='index.php';</script>";
} catch (Throwable $e) {
  // During dev you can expose the error for clarity:
  if ($isAjax) jsonResponse('error', 'Registration failed: '.$e->getMessage(), 500);
  echo "<script>alert('Registration failed. Please try again.'); window.location='index.php';</script>";
}