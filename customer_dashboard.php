<h2>Your Inquiries</h2>

<?php
$stmt = $pdo->prepare("SELECT * FROM inquiries WHERE customer_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['customer_id']]);
$inquiries = $stmt->fetchAll();
?>

<?php if (count($inquiries) > 0): ?>
    <ul>
    <?php foreach ($inquiries as $inq): ?>
        <li>
            Subject: <?= htmlspecialchars($inq['subject']) ?><br>
            Message: <?= nl2br(htmlspecialchars($inq['message'])) ?><br>
            Status: <?= htmlspecialchars($inq['status']) ?><br>
            <?php if ($inq['status'] === 'answered'): ?>
                <strong>Therapist Response:</strong> <?= nl2br(htmlspecialchars($inq['response'])) ?><br>
                Responded at: <?= htmlspecialchars($inq['responded_at']) ?>
            <?php endif; ?>
        </li>
        <hr>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No inquiries yet.</p>
<?php endif; ?>
