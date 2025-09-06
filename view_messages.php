<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}


// Ensure user is logged in and is admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

// Handle reply submission
if(isset($_POST['reply_id']) && isset($_POST['reply_message'])) {
    $reply_id = intval($_POST['reply_id']);
    $reply_message = $conn->real_escape_string($_POST['reply_message']);

    // Check if a reply already exists for this user message
    $check_sql = "
        SELECT id FROM admin_messages 
        WHERE customer_id = (SELECT customer_id FROM user_messages WHERE id = $reply_id)
          AND subject = 'Support Reply'
    ";
    $check_result = $conn->query($check_sql);

    if($check_result->num_rows == 0) {
        // Insert reply into admin_messages table and mark as replied
        $insert_sql = "
            INSERT INTO admin_messages (customer_id, subject, message, status)
            SELECT customer_id, 'Support Reply', '$reply_message', 'replied'
            FROM user_messages
            WHERE id = $reply_id
        ";
        $conn->query($insert_sql);

        // Optionally, you can update status in user_messages (if you want to track)
        $update_sql = "UPDATE user_messages SET message = message WHERE id = $reply_id"; // Placeholder
        $conn->query($update_sql);
    }
}

// Fetch all customer support messages (unreplied and replied)
$sql = "
    SELECT 
        um.id AS message_id,
        c.name AS customer_name,
        c.email,
        um.message AS customer_message,
        um.created_at AS sent_on,
        am.message AS reply_message,
        am.status AS reply_status
    FROM user_messages um
    JOIN customers c ON c.id = um.customer_id
    LEFT JOIN admin_messages am 
        ON am.customer_id = um.customer_id AND am.subject='Support Reply'
    WHERE um.subject LIKE 'Support%'
    ORDER BY um.created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Customer Support Messages</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    h2 { color: #00aaff; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px;}
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
    th { background: #00aaff; color: #fff;}
    tr:hover { background: #f1f1f1;}
    textarea { width: 100%; padding: 8px; margin-top:5px; border-radius:5px; border:1px solid #ccc; resize: vertical;}
    button { padding: 8px 15px; background: #00aaff; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top:5px;}
    button:hover { background: #008ecc; }
    .replied { background: #d4edda; }
    form { margin-top:10px; }
</style>
</head>
<body>

<div class="container">
    <h2>Customer Support Messages</h2>

    <?php if($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Message</th>
                <th>Reply</th>
                <th>Sent On</th>
            </tr>
            <?php $count=1; while($row = $result->fetch_assoc()): ?>
            <tr class="<?= ($row['reply_status']=='replied') ? 'replied' : ''; ?>">
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['customer_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= nl2br(htmlspecialchars($row['customer_message'])); ?></td>
                <td>
                    <?php if($row['reply_status']=='replied'): ?>
                        <?= nl2br(htmlspecialchars($row['reply_message'])); ?>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="reply_id" value="<?= $row['message_id']; ?>">
                            <textarea name="reply_message" placeholder="Type reply here..." required></textarea>
                            <button type="submit">Send Reply</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td><?= $row['sent_on']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No support messages found.</p>
    <?php endif; ?>

    <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
