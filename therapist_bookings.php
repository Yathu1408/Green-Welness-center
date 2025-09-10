<?php
session_start();
require 'db.php';

// Ensure only therapist can access
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'therapist'){
    header("Location: login.php");
    exit;
}

$therapist_id = $_SESSION['customer_id']; // therapist is also stored in users.id

$stmt = $pdo->prepare("
    SELECT b.id, u.name AS customer_name, b.service, b.booking_date, b.booking_time, b.created_at
    FROM bookings b
    JOIN users u ON b.customer_id = u.id
    WHERE b.therapist_id = ?
    ORDER BY b.booking_date DESC, b.booking_time DESC
");
$stmt->execute([$therapist_id]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Bookings - Therapist</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>My Assigned Bookings</h1>
  <table border="1" cellpadding="8">
    <tr>
      <th>ID</th>
      <th>Customer</th>
      <th>Service</th>
      <th>Date</th>
      <th>Time</th>
      <th>Booked At</th>
    </tr>
    <?php foreach($bookings as $b): ?>
      <tr>
        <td><?= $b['id'] ?></td>
        <td><?= htmlspecialchars($b['customer_name']) ?></td>
        <td><?= htmlspecialchars($b['service']) ?></td>
        <td><?= $b['booking_date'] ?></td>
        <td><?= date("h:i A", strtotime($b['booking_time'])) ?></td>
        <td><?= $b['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
