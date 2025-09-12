<?php
session_start();
require 'db.php';

// Ensure only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("
    SELECT b.id, 
           uc.name AS customer_name, 
           ut.name AS therapist_name, 
           b.service, b.booking_date, b.booking_time, b.created_at
    FROM bookings b
    JOIN users uc ON b.customer_id = uc.id
    JOIN users ut ON b.therapist_id = ut.id
    ORDER BY b.booking_date DESC, b.booking_time DESC
");
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Bookings - Admin</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>All Service Bookings</h1>
  <table border="1" cellpadding="8">
    <tr>
      <th>ID</th>
      <th>Customer</th>
      <th>Therapist</th>
      <th>Service</th>
      <th>Date</th>
      <th>Time</th>
      <th>Booked At</th>
    </tr>
    <?php if(count($bookings) > 0): ?>
      <?php foreach($bookings as $b): ?>
      <tr>
        <td><?= $b['id'] ?></td>
        <td><?= htmlspecialchars($b['customer_name']) ?></td>
        <td><?= htmlspecialchars($b['therapist_name']) ?></td>
        <td><?= htmlspecialchars($b['service']) ?></td>
        <td><?= $b['booking_date'] ?></td>
        <td><?= date("h:i A", strtotime($b['booking_time'])) ?></td>
        <td><?= $b['created_at'] ?></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;">No bookings found.</td></tr>
    <?php endif; ?>
  </table>
<div><button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button></div>
  <style>/* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #ff9100ff; /* Green title */
    margin-top: 30px;
}

table {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #026300ff; /* Orange header */
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

tr:hover {
    background-color: #e6f4ea; /* Light green on hover */
}

td {
    color: #333;
}

table tr:last-child td {
    border-bottom: none;
}

@media (max-width: 768px) {
    table, th, td {
        display: block;
        width: 100%;
    }
    th {
        text-align: right;
        padding-right: 50%;
        position: relative;
    }
    th::after {
        content: ":";
        position: absolute;
        right: 15px;
    }
    td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        text-transform: uppercase;
    }
}
button { 
    padding: 8px 15px; 
    margin-left: 80px;
    background: #ff7700ff; 
    color: #fff;
     border: none; 
     border-radius: 5px; 
     cursor: pointer; 
     margin-top:10px;}
button:hover { 
    background: #003402ff;
 }

</style>
</body>
</html>
