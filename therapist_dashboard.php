<?php
session_start();
require 'db.php'; // $pdo

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    header("Location: login.php");
    exit();
}

$therapist_id   = $_SESSION['user_id'];
$therapist_name = $_SESSION['name'];

// (Optional) success message
$message = "";

// Fetch appointments
$stmt = $pdo->prepare("
    SELECT b.id, c.name AS customer_name, c.email, b.service, b.booking_date, b.booking_time
    FROM bookings b
    JOIN customers c ON c.id = b.customer_id
    WHERE b.therapist_id = ?
    ORDER BY b.booking_date DESC
");

$stmt->execute([$therapist_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages
$stmt = $pdo->prepare("
    SELECT um.id, c.name AS customer_name, um.message, um.status, um.created_at
    FROM user_messages um
    JOIN customers c ON c.id = um.customer_id
    WHERE um.therapist_id = ?
    ORDER BY um.created_at DESC
");
$stmt->execute([$therapist_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard</title>
</head>
<body>
    <h1>Therapist Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($therapist_name) ?> (Therapist)</p>
    <a href="logout.php">Logout</a>

    <?php if (!empty($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h2>Appointments</h2>
    <?php if (count($appointments) > 0): ?>
        <ul>
        <?php foreach ($appointments as $appt): ?>
            <li>
                <?= htmlspecialchars($appt['customer_name']) ?> - 
                <?= htmlspecialchars($appt['service']) ?> on 
                <?= htmlspecialchars($appt['booking_date']) ?> at 
                <?= htmlspecialchars($appt['booking_time']) ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>

    <h2>Messages from Customers</h2>
    <?php if (count($messages) > 0): ?>
        <ul>
        <?php foreach ($messages as $msg): ?>
            <li>
                From <?= htmlspecialchars($msg['customer_name']) ?>: 
                <?= htmlspecialchars($msg['message']) ?> (<?= htmlspecialchars($msg['status']) ?>)
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>
</body>
</html>
