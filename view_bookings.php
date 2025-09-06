<?php
session_start();
require 'db.php';

// Admin role check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all bookings with customer info
$sql = "SELECT b.id, c.name AS customer_name, c.email, b.service, b.booking_date, b.booking_time, b.created_at
        FROM bookings b
        JOIN customers c ON c.id = b.customer_id
        ORDER BY b.booking_date ASC, b.booking_time ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - View Bookings</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    h2 { color: #00aaff; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px;}
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #00aaff; color: #fff;}
    tr:hover { background: #f1f1f1;}
    button { padding: 8px 15px; background: #00aaff; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top:10px;}
    button:hover { background: #008ecc; }
</style>
</head>
<body>

<div class="container">
    <h2>All Bookings</h2>

    <?php if($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Booking Created</th>
            </tr>
            <?php $count=1; while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['customer_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['service']); ?></td>
                <td><?= date("d-m-Y", strtotime($row['booking_date'])); ?></td>
                <td><?= date("h:i A", strtotime($row['booking_time'])); ?></td>
                <td><?= date("d-m-Y h:i A", strtotime($row['created_at'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No bookings found.</p>
    <?php endif; ?>

    <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
