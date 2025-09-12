<?php
session_start();
require 'db.php';

// ✅ Only admin or therapist can access
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'therapist'])) {
    header("Location: index.php");
    exit;
}

// Handle response submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['response'])) {
    $id = $_POST['id'];
    $response = $_POST['response'];

    $stmt = $pdo->prepare("UPDATE inquiries 
                           SET response = :response, status = 'answered', responded_at = NOW() 
                           WHERE id = :id");
    $stmt->execute([':response' => $response, ':id' => $id]);

    header("Location: manage_inquiries.php");
    exit;
}

// Fetch all inquiries with user info
$stmt = $pdo->query("SELECT i.*, u.name AS customer_name 
                     FROM inquiries i 
                     JOIN users u ON i.customer_id = u.id
                     ORDER BY i.created_at DESC");
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Inquiries</title>
<style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f4f4f4; }
    form { margin: 0; }
    textarea { width: 100%; }
    button { padding: 5px 10px; margin-top: 5px; }
</style>
</head>
<body>

<h1>Manage Customer Inquiries</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Type</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Response</th>
            <th>Responded At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inquiries as $inq): ?>
        <tr>
            <td><?= htmlspecialchars($inq['id']) ?></td>
            <td><?= htmlspecialchars($inq['customer_name']) ?></td>
            <td><?= htmlspecialchars($inq['type']) ?></td>
            <td><?= htmlspecialchars($inq['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($inq['message'])) ?></td>
            <td><?= htmlspecialchars($inq['status']) ?></td>
            <td>
                <?php if ($inq['status'] === 'answered'): ?>
                    <?= nl2br(htmlspecialchars($inq['response'])) ?>
                <?php else: ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                        <textarea name="response" rows="3" required></textarea>
                        <button type="submit">Respond</button>
                    </form>
                <?php endif; ?>
            </td>
            <td><?= $inq['responded_at'] ?? '-' ?></td>
            <td><!-- Optional: delete button here --></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
