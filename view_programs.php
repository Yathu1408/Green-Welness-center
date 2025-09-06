<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

// Fetch programs with registered customers
$sql = "SELECT p.program_name, c.name AS customer_name, c.email, pr.registered_at
        FROM program_registrations pr
        JOIN programs p ON pr.program_id = p.id
        JOIN customers c ON pr.customer_id = c.id
        ORDER BY p.program_name, pr.registered_at";

$registrations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Registrations | Admin</title>
</head>
<body>
    <h1>Program Registrations</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>

    <?php if ($registrations): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Program</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
            <?php foreach ($registrations as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['program_name']); ?></td>
                    <td><?= htmlspecialchars($r['customer_name']); ?></td>
                    <td><?= htmlspecialchars($r['email']); ?></td>
                    <td><?= htmlspecialchars($r['registered_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No program registrations found.</p>
    <?php endif; ?>
</body>
</html>
