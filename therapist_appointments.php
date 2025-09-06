<?php
session_start();
require 'db.php';

// Therapist role check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    header("Location: index.php");
    exit();
}

$therapist_id = $_SESSION["user_id"];

// Fetch therapist's appointments
$sql = "SELECT b.id, c.name AS customer_name, c.phone, c.email, 
               b.service, b.booking_date, b.booking_time, b.created_at
        FROM bookings b
        JOIN customers c ON b.customer_id = c.id
        WHERE b.therapist_id = ?
        ORDER BY b.booking_date ASC, b.booking_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Appointments | Greenlife Wellness Center</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
    .appointments-container { max-width: 1000px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h1 { color: #ff7300; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
    th { background: #ff7300; color: #fff; }
    tr:hover { background: #f1f1f1; }
    button { display: block; margin: 20px auto 0; padding: 12px 25px; background: #333; color: #fff; border: none; border-radius: 8px; cursor: pointer; }
    button:hover { background: #555; }
</style>
</head>
<body>

<div class="appointments-container">
    <h1>My Appointments</h1>
    <p>Welcome, <strong><?= htmlspecialchars($_SESSION['name']); ?></strong></p>

    <?php if ($appointments): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php $count = 1; foreach ($appointments as $appt): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($appt['customer_name']); ?></td>
                    <td><?= htmlspecialchars($appt['phone']); ?></td>
                    <td><?= htmlspecialchars($appt['email']); ?></td>
                    <td><?= htmlspecialchars($appt['service']); ?></td>
                    <td><?= date("d-m-Y", strtotime($appt['booking_date'])); ?></td>
                    <td><?= date("h:i A", strtotime($appt['booking_time'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No appointments found.</p>
    <?php endif; ?>

    <button onclick="window.location.href='therapist_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
