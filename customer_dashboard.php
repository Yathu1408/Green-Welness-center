<?php
session_start();
require 'db.php'; // Make sure db.php defines $pdo as PDO connection

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header('customer_dashboard.php');
    exit;
}

// Fetch inquiries for logged-in user
$stmt = $pdo->prepare("SELECT * FROM inquiries WHERE customer_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Your Inquiries</h2>

<?php if (count($inquiries) > 0): ?>
    <ul>
        <?php foreach ($inquiries as $inq): ?>
            <li>
                <strong>Type:</strong> <?= htmlspecialchars($inq['type']) ?><br>
                <strong>Subject:</strong> <?= htmlspecialchars($inq['subject']) ?><br>
                <strong>Message:</strong> <?= nl2br(htmlspecialchars($inq['message'])) ?><br>
                <strong>Status:</strong> <?= htmlspecialchars($inq['status']) ?><br>
                <?php if ($inq['status'] === 'answered'): ?>
                    <strong>Therapist Response:</strong> <?= nl2br(htmlspecialchars($inq['response'])) ?><br>
                    <strong>Responded at:</strong> <?= htmlspecialchars($inq['responded_at']) ?>
                <?php endif; ?>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No inquiries yet.</p>
<?php endif; ?>
