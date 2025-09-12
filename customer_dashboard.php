<?php
session_start();
require 'db.php';

// -------------------------
// 1️⃣ Check if customer is logged in
// -------------------------
if (!isset($_SESSION['customer_id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$customerName = $_SESSION['customer_name'];

// -------------------------
// 2️⃣ Fetch customer info
// -------------------------
$stmt = $pdo->prepare("SELECT id, name, legalid, phone, email, created_at FROM users WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// -------------------------
// 3️⃣ Fetch bookings
// -------------------------
$stmt = $pdo->prepare("
    SELECT b.service, b.booking_date, b.booking_time, u.name AS therapist_name
    FROM bookings b
    JOIN users u ON b.therapist_id = u.id
    WHERE b.customer_id = ?
    ORDER BY b.booking_date DESC, b.booking_time DESC
");
$stmt->execute([$customer_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// 4️⃣ Fetch program registrations
// -------------------------
// 🔹 Set this to the actual column name in your programmes table that stores program name
$programColumn = 'title'; // <-- replace 'title' with the correct column name

$stmt = $pdo->prepare("
    SELECT r.status, r.notes, r.created_at, p.$programColumn AS programme_name
    FROM registrations r
    JOIN programmes p ON r.programme_id = p.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$customer_id]);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// 5️⃣ Fetch inquiries
// -------------------------
$stmt = $pdo->prepare("
    SELECT type, subject, message, response, status, created_at, responded_at
    FROM inquiries
    WHERE customer_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$customer_id]);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h2 { color: #000001ff; margin-bottom: 10px; border-bottom: 2px solid #f36602ff; padding-bottom: 5px; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 30px; }
        .card table { width: 100%; border-collapse: collapse; }
        .card table th, .card table td { padding: 12px; text-align: left; }
        .card table th { background: #0e54007a; color: #fff; }
        .card table tr:nth-child(even) { background: #f2f2f2; }
        .status { padding: 5px 10px; border-radius: 6px; font-weight: bold; color: #fff; display: inline-block; }
        .answered { background-color: #037131ff; }
        .pending { background-color: #d6a800ff; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .section-header i { font-size: 24px; color: #ff7504ff; }
        p.no-data { text-align: center; color: #7f8c8d; font-style: italic; margin: 20px 0; }
        td pre { margin: 0; font-family: inherit; }
    </style>
</head>
<body>

<!-- Back to Homepage Button -->
<div style="margin-bottom: 20px;">
    <a href="index.php" 
       style="text-decoration: none; background-color: #02531392; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; display: inline-flex; align-items: center;">
        <i class="ri-arrow-left-line" style="margin-right: 8px;"></i> Back to Homepage
    </a>
</div>

<!-- Customer Info -->
<div class="card">
    <div class="section-header">
        <h2><i class="ri-user-line"></i> Customer Information</h2>
    </div>
    <table>
        <tr><th>Name</th><td><?= htmlspecialchars($customer['name']) ?></td></tr>
        <tr><th>Legal ID</th><td><?= htmlspecialchars($customer['legalid']) ?></td></tr>
        <tr><th>Phone</th><td><?= htmlspecialchars($customer['phone']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($customer['email']) ?></td></tr>
        <tr><th>Joined</th><td><?= htmlspecialchars($customer['created_at']) ?></td></tr>
    </table>
</div>

<!-- Bookings -->
<div class="card">
    <div class="section-header">
        <h2><i class="ri-calendar-line"></i> Bookings</h2>
    </div>
    <?php if(count($bookings) > 0): ?>
    <table>
        <tr>
            <th>Service</th>
            <th>Therapist</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php foreach($bookings as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['service']) ?></td>
            <td><?= htmlspecialchars($b['therapist_name']) ?></td>
            <td><?= htmlspecialchars($b['booking_date']) ?></td>
            <td><?= htmlspecialchars($b['booking_time']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p class="no-data">No bookings found.</p>
    <?php endif; ?>
</div>

<!-- Program Registrations -->
<div class="card">
    <div class="section-header">
        <h2><i class="ri-file-list-3-line"></i> Program Registrations</h2>
    </div>
    <?php if(count($registrations) > 0): ?>
    <table>
        <tr>
            <th>Program</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Registered At</th>
        </tr>
        <?php foreach($registrations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['programme_name']) ?></td>
            <td><span class="status <?= $r['status'] ?>"><?= htmlspecialchars($r['status']) ?></span></td>
            <td><?= htmlspecialchars($r['notes']) ?></td>
            <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p class="no-data">No program registrations found.</p>
    <?php endif; ?>
</div>

<!-- Inquiries -->
<div class="card">
    <div class="section-header">
        <h2><i class="ri-mail-line"></i> Inquiries</h2>
    </div>
    <?php if(count($inquiries) > 0): ?>
    <table>
        <tr>
            <th>Type</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Response</th>
            <th>Created At</th>
            <th>Responded At</th>
        </tr>
        <?php foreach($inquiries as $i): ?>
        <tr>
            <td><?= htmlspecialchars($i['type']) ?></td>
            <td><?= htmlspecialchars($i['subject']) ?></td>
            <td><pre><?= htmlspecialchars($i['message']) ?></pre></td>
            <td><span class="status <?= $i['status'] ?>"><?= htmlspecialchars($i['status']) ?></span></td>
            <td><pre><?= htmlspecialchars($i['response']) ?></pre></td>
            <td><?= htmlspecialchars($i['created_at']) ?></td>
            <td><?= htmlspecialchars($i['responded_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p class="no-data">No inquiries found.</p>
    <?php endif; ?>
</div>

</body>
</html>
