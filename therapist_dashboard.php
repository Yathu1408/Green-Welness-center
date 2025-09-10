<?php
session_start();
require 'db.php'; // Make sure $pdo is defined

// Check therapist login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    header("Location: login.php");
    exit();
}

$therapist_id   = $_SESSION['user_id'];
$therapist_name = $_SESSION['name'];
$therapist_legalid = $_SESSION['legalid']; // Needed for inquiries mapping

// Optional success message
$message = "";

// --- Fetch appointments ---
$stmt = $pdo->prepare("
    SELECT b.id, u.name AS customer_name, u.email, b.service, b.booking_date, b.booking_time
    FROM bookings b
    JOIN users u ON u.id = b.customer_id
    WHERE b.therapist_id = ?
    ORDER BY b.booking_date DESC
");
$stmt->execute([$therapist_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Map therapist legalid to inquiry type ---
$therapist_map = [
    'THERA001' => 'ayurveda',
    'THERA002' => 'yoga',
    'THERA003' => 'meditation',
    'THERA004' => 'wellness-consultation',
    'ADMIN001' => 'customer-support',
];

$inquiry_type = $therapist_map[$therapist_legalid] ?? null;

// --- Fetch inquiries for this therapist ---
if ($inquiry_type) {
    $stmt = $pdo->prepare("
        SELECT i.*, u.name AS customer_name
        FROM inquiries i
        JOIN users u ON u.id = i.customer_id
        WHERE i.type = ?
        ORDER BY i.created_at DESC
    ");
    $stmt->execute([$inquiry_type]);
    $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $inquiries = [];
}

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Therapist Dashboard Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #cbe6af47;

        }

        h1 {
            color: #ff7300;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .dashboard-section {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-section h2 {
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .appointment-list, .inquiry-list {
            list-style: none;
            padding: 0;
        }

        .appointment-list li {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .appointment-list li:last-child {
            border-bottom: none;
        }

        .inquiry-item {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .response-form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .response-form button {
            background-color: #5cb85c;
            color: white;
        }
        </style>


    <title>Therapist Dashboard</title>
</head>
<body>
    <h1>Therapist Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($therapist_name) ?> (Therapist)</p>
    <a href="logout.php">Logout</a>

    <?php if (!empty($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Appointments -->
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

    <!-- Inquiries -->
    <h2>Customer Inquiries</h2>
    <?php if (count($inquiries) > 0): ?>
        <ul>
        <?php foreach ($inquiries as $inq): ?>
            <li>
                <strong>From:</strong> <?= htmlspecialchars($inq['customer_name']) ?><br>
                <strong>Subject:</strong> <?= htmlspecialchars($inq['subject']) ?><br>
                <strong>Message:</strong> <?= htmlspecialchars($inq['message']) ?><br>
                <strong>Status:</strong> <?= htmlspecialchars($inq['status']) ?><br>

                <!-- Response Form -->
                <?php if ($inq['status'] === 'pending'): ?>
                    <form method="post" action="response_inquiry.php">
                        <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                        <textarea name="response" placeholder="Write your response here" required></textarea><br>
                        <button type="submit">Send Response</button>
                    </form>
                <?php else: ?>
                    <strong>Response:</strong> <?= htmlspecialchars($inq['response']) ?><br>
                    <em>Responded at: <?= htmlspecialchars($inq['responded_at']) ?></em>
                <?php endif; ?>
            </li>
            <hr>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No inquiries found.</p>
    <?php endif; ?>
</body>
</html>
