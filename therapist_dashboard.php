<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    header("Location: login.php");
    exit();
}

$therapist_id   = $_SESSION['user_id'];
$therapist_name = $_SESSION['name'];
$therapist_legalid = $_SESSION['legalid'];

$message = "";

// Fetch appointments
$stmt = $pdo->prepare("
    SELECT b.id, u.name AS customer_name, u.email, b.service, b.booking_date, b.booking_time
    FROM bookings b
    JOIN users u ON u.id = b.customer_id
    WHERE b.therapist_id = ?
    ORDER BY b.booking_date DESC
");
$stmt->execute([$therapist_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$appointments_count = count($appointments);

// Map legalid to inquiry type
$therapist_map = [
    'THERA001' => 'ayurveda',
    'THERA002' => 'yoga',
    'THERA003' => 'meditation',
    'THERA004' => 'wellness-consultation',
    'ADMIN001' => 'customer-support',
];
$inquiry_type = $therapist_map[$therapist_legalid] ?? null;

// Fetch inquiries
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
$inquiries_count = count($inquiries);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard</title>
    <style>
        /* Reset and basic styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #cbe6af47, #ffffff);
            padding: 20px;
            color: #333;
        }

        a {
            color: #ff7300;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        h1 {
            text-align: center;
            color: #2b5d34;
            margin-bottom: 10px;
        }

        .welcome-msg {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1em;
            color: #555;
        }

        .logout-btn {
            display: block;
            width: max-content;
            margin: 0 auto 30px auto;
            padding: 8px 16px;
            background-color: #ff7300;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background-color: #e06500;
        }

        .dashboard-section {
            background-color: #fff;
            padding: 20px 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .dashboard-section h2 {
            color: #2b5d34;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.5em;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .count-badge {
            background-color: #ff7300;
            color: #fff;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.9em;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        .appointment-list li, .inquiry-item {
            background-color: #f9f9f9;
            margin-bottom: 12px;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .appointment-list li:hover, .inquiry-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .inquiry-item strong {
            display: inline-block;
            width: 90px;
            color: #2b5d34;
        }

        .response-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
        }

        .response-form button {
            margin-top: 10px;
            background-color: #2b5d34;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .response-form button:hover {
            background-color: #1d3f23;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .no-data {
            color: #888;
            font-style: italic;
        }

        .message-success {
            color: #4caf50;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Therapist Dashboard</h1>
    <p class="welcome-msg">Welcome, <?= htmlspecialchars($therapist_name) ?> (Therapist)</p>
    <a class="logout-btn" href="logout.php">Logout</a>

    <?php if (!empty($message)): ?>
        <p class="message-success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Appointments -->
    <div class="dashboard-section">
        <h2>Appointments <span class="count-badge"><?= $appointments_count ?></span></h2>
        <?php if ($appointments_count > 0): ?>
            <ul class="appointment-list">
            <?php foreach ($appointments as $appt): ?>
                <li>
                    <strong><?= htmlspecialchars($appt['customer_name']) ?></strong> - 
                    <?= htmlspecialchars($appt['service']) ?> on 
                    <?= htmlspecialchars($appt['booking_date']) ?> at 
                    <?= htmlspecialchars($appt['booking_time']) ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-data">No appointments found.</p>
        <?php endif; ?>
    </div>

    <!-- Inquiries -->
    <div class="dashboard-section">
        <h2>Customer Inquiries <span class="count-badge"><?= $inquiries_count ?></span></h2>
        <?php if ($inquiries_count > 0): ?>
            <ul class="inquiry-list">
            <?php foreach ($inquiries as $inq): ?>
                <li class="inquiry-item">
                    <strong>From:</strong> <?= htmlspecialchars($inq['customer_name']) ?><br>
                    <strong>Subject:</strong> <?= htmlspecialchars($inq['subject']) ?><br>
                    <strong>Message:</strong> <?= htmlspecialchars($inq['message']) ?><br>
                    <strong>Status:</strong> <?= htmlspecialchars($inq['status']) ?><br>

                    <?php if ($inq['status'] === 'pending'): ?>
                        <form class="response-form" method="post" action="response_inquiry.php">
                            <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                            <textarea name="response" placeholder="Write your response here" required></textarea><br>
                            <button type="submit">Send Response</button>
                        </form>
                    <?php else: ?>
                        <strong>Response:</strong> <?= htmlspecialchars($inq['response']) ?><br>
                        <em>Responded at: <?= htmlspecialchars($inq['responded_at']) ?></em>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-data">No inquiries found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
