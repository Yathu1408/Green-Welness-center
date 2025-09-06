<?php
session_start();
require 'db.php'; // include your database connection

// Ensure user is logged in and is a therapist
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "therapist") {
    header("Location: index.php");
    exit();
}

// Get therapist name from session
$therapist_name = $_SESSION['name'];

// Fetch appointments assigned to this therapist
$sql = "SELECT b.id, c.name AS customer_name, c.email, b.service, b.booking_date, b.booking_time
        FROM bookings b
        JOIN customers c ON b.customer_id = c.id
        WHERE b.service IN (
            SELECT service FROM customers WHERE id = c.id
        ) AND b.therapist_name = ?
        ORDER BY b.booking_date, b.booking_time";

$stmt = $conn->prepare("SELECT b.id, c.name AS customer_name, c.email, b.service, b.booking_date, b.booking_time
                        FROM bookings b
                        JOIN customers c ON b.customer_id = c.id
                        WHERE b.therapist_name = ?
                        ORDER BY b.booking_date, b.booking_time");
$stmt->bind_param("s", $therapist_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Appointments | Therapist</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
    .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    h2 { color: #00aaff; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px;}
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left;}
    th { background: #00aaff; color: #fff;}
    tr:hover { background: #f1f1f1;}
    button { padding: 10px 20px; background: #333; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;}
    button:hover { background: #555; }
</style>
</head>
<body>

<div class="container">
    <h2>My Appointments</h2>

    <?php if($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['customer_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['service']); ?></td>
                <td><?= htmlspecialchars($row['booking_date']); ?></td>
                <td><?= htmlspecialchars($row['booking_time']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No appointments assigned yet.</p>
    <?php endif; ?>

    <button onclick="window.location.href='therapist_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
