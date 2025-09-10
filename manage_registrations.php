<?php
session_start();
require 'db.php';

// allow only admin or therapist
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','therapist'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("
  SELECT r.*, u.name AS user_name, u.email, p.title AS programme_title, p.date_info
  FROM registrations r
  JOIN users u ON r.user_id = u.id
  JOIN programmes p ON r.programme_id = p.id
  ORDER BY r.created_at DESC
");
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Manage Registrations</title></head>
<body>
<h2>Programme Registrations</h2>
<table border="1" cellpadding="8" cellspacing="0">
  <thead>
    <tr><th>ID</th><th>User</th><th>Email</th><th>Programme</th><th>Date Info</th><th>Status</th><th>Registered At</th><th>Action</th></tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['id']) ?></td>
        <td><?= htmlspecialchars($r['user_name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['programme_title']) ?></td>
        <td><?= htmlspecialchars($r['date_info']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
        <td>
          <!-- Example action: cancel registration -->
          <?php if ($r['status'] === 'registered'): ?>
            <form method="post" action="update_registration_status.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= $r['id'] ?>">
              <input type="hidden" name="status" value="cancelled">
              <button type="submit">Cancel</button>
            </form>
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</body>
</html>
