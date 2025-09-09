<?php
session_start();
require 'db.php';

// ✅ Allow only admin or therapist
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','therapist'])) {
    header("Location: index.php");
    exit;
}

// Fetch all inquiries with customer name from `users`
$stmt = $pdo->query("SELECT i.*, u.name AS customer_name 
                     FROM inquiries i 
                     JOIN users u ON i.customer_id = u.id 
                     ORDER BY i.created_at DESC");
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Customer Inquiries</h2>
<?php foreach ($inquiries as $inq): ?>
  <div style="border:1px solid #ccc; padding:10px; margin:10px;">
    <p><strong><?= htmlspecialchars($inq['customer_name']) ?></strong> (<?= $inq['type'] ?>)</p>
    <p><b>Subject:</b> <?= htmlspecialchars($inq['subject']) ?></p>
    <p><b>Message:</b> <?= nl2br(htmlspecialchars($inq['message'])) ?></p>
    <?php if ($inq['response']): ?>
      <p><b>Response:</b> <?= nl2br(htmlspecialchars($inq['response'])) ?></p>
    <?php else: ?>
      <form method="post" action="respond_inquiry.php">
        <input type="hidden" name="id" value="<?= $inq['id'] ?>">
        <textarea name="response" rows="3" required></textarea><br>
        <button type="submit">Send Response</button>
      </form>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
