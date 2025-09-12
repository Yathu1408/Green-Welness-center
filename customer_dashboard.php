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
// 2️⃣ Fetch bookings
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
$totalBookings = count($bookings);

// -------------------------
// 3️⃣ Fetch program registrations
// -------------------------
$stmt = $pdo->prepare("
    SELECT r.status, r.notes, r.created_at, p.programme_name AS programme_name
    FROM registrations r
    JOIN programmes p ON r.programme_id = p.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$customer_id]);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPrograms = count($registrations);

// -------------------------
// 4️⃣ Fetch inquiries
// -------------------------
$stmt = $pdo->prepare("
    SELECT type, subject, message, response, status, created_at, responded_at
    FROM inquiries
    WHERE customer_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$customer_id]);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pendingInquiries = count(array_filter($inquiries, fn($i) => $i['status'] === 'pending'));
$answeredInquiries = count(array_filter($inquiries, fn($i) => $i['status'] === 'answered'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    margin: 0;
    padding: 20px;
}

/* Back button */
.back-home-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #6c6c6cff;
    color: #fff;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: background-color 0.3s;
    z-index: 1000;
}
.back-home-btn:hover { background-color: #1f618d; }
.back-home-btn i { margin-right: 6px; font-size: 18px; }

/* Tiles */
.tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.tile {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 20px;
    display: flex;
    align-items: center;
    transition: transform 0.2s;
}
.tile:hover { transform: translateY(-5px); }

.tile i {
    font-size: 36px;
    margin-right: 15px;
    color: #fff;
    padding: 15px;
    border-radius: 50%;
}

.tile .content { display: flex; flex-direction: column; }
.tile .content .number { font-size: 24px; font-weight: bold; }
.tile .content .label { font-size: 14px; color: #7f8c8d; }

/* Tile colors */
.tile.bookings i { background-color: #dc8f00ff; }
.tile.programs i { background-color: #27ae60; }
.tile.pending i { background-color: #f39c12; }
.tile.answered i{ background-color: #27ae60; }
/* Card tables */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 30px;
}

.card table {
    width: 100%;
    border-collapse: collapse;
}

.card table th, .card table td {
    padding: 12px;
    text-align: left;
}

.card table th {
    background: #137f5eff;
    color: #fff;
}

.card table tr:nth-child(even) {
    background: #f2f2f2;
}

.status { padding: 5px 10px; border-radius: 6px; font-weight: bold; color: #000000ff; display: inline-block; }
.answered { background-color: #ffffffff; }
.pending { background-color: #ffffffff; }

p.no-data { text-align: center; color: #7f8c8d; font-style: italic; margin: 20px 0; }
</style>
</head>
<body>

<a href="index.php" class="back-home-btn"><i class="ri-arrow-left-line"></i> Back to Homepage</a>

<!-- Summary Tiles -->
<div class="tiles">
    <div class="tile bookings">
        <i class="ri-calendar-line"></i>
        <div class="content">
            <div class="number"><?= $totalBookings ?></div>
            <div class="label">Total Bookings</div>
        </div>
    </div>
    <div class="tile programs">
        <i class="ri-file-list-3-line"></i>
        <div class="content">
            <div class="number"><?= $totalPrograms ?></div>
            <div class="label">Programs Registered</div>
        </div>
    </div>
    <div class="tile pending">
        <i class="ri-mail-unread-line"></i>
        <div class="content">
            <div class="number"><?= $pendingInquiries ?></div>
            <div class="label">Pending Inquiries</div>
        </div>
    </div>
    <div class="tile answered">
        <i class="ri-mail-check-line"></i>
        <div class="content">
            <div class="number"><?= $answeredInquiries ?></div>
            <div class="label">Answered Inquiries</div>
        </div>
    </div>
</div>

<!-- Optional detailed tables -->
<div class="card">
<h2>Bookings Details</h2>
<?php if($totalBookings>0): ?>
<table>
<tr><th>Service</th><th>Therapist</th><th>Date</th><th>Time</th></tr>
<?php foreach($bookings as $b): ?>
<tr>
<td><?= htmlspecialchars($b['service']) ?></td>
<td><?= htmlspecialchars($b['therapist_name']) ?></td>
<td><?= htmlspecialchars($b['booking_date']) ?></td>
<td><?= htmlspecialchars($b['booking_time']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?><p class="no-data">No bookings found.</p><?php endif; ?>
</div>

<div class="card">
<h2>Program Registrations</h2>
<?php if($totalPrograms>0): ?>
<table>
<tr><th>Program</th><th>Status</th><th>Notes</th><th>Registered At</th></tr>
<?php foreach($registrations as $r): ?>
<tr>
<td><?= htmlspecialchars($r['programme_name']) ?></td>
<td><span class="status <?= $r['status'] ?>"><?= htmlspecialchars($r['status']) ?></span></td>
<td><?= htmlspecialchars($r['notes']) ?></td>
<td><?= htmlspecialchars($r['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?><p class="no-data">No program registrations found.</p><?php endif; ?>
</div>

<div class="card">
<h2>Inquiries</h2>
<?php if(count($inquiries)>0): ?>
<table>
<tr><th>Type</th><th>Subject</th><th>Message</th><th>Status</th><th>Response</th></tr>
<?php foreach($inquiries as $i): ?>
<tr>
<td><?= htmlspecialchars($i['type']) ?></td>
<td><?= htmlspecialchars($i['subject']) ?></td>
<td><pre><?= htmlspecialchars($i['message']) ?></pre></td>
<td><span class="status <?= $i['status'] ?>"><?= htmlspecialchars($i['status']) ?></span></td>
<td><pre><?= htmlspecialchars($i['response']) ?></pre></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?><p class="no-data">No inquiries found.</p><?php endif; ?>
</div>

</body>
</html>
