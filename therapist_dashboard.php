<?php
session_start();
require 'db.php';

// Role-based session check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist'){
    header("Location: index.php");
    exit();
}

$therapist_id = $_SESSION["user_id"];
$therapist_name = $_SESSION["name"];
$message = "";

// Handle reply submission
if(isset($_POST['reply'], $_POST['message_id'], $_POST['reply_message'])) {
    $message_id = intval($_POST['message_id']);
    $reply_message = $conn->real_escape_string($_POST['reply_message']);
    
    // Update user_messages table with reply
    $conn->query("UPDATE user_messages SET message='$reply_message', status='replied' WHERE id=$message_id");
    $message = "Reply sent successfully!";
}

// Fetch appointments assigned to this therapist
$sql = "SELECT b.id, c.name AS customer_name, c.email, b.service, b.booking_date, b.booking_time
        FROM bookings b
        JOIN customers c ON c.id = b.customer_id
        WHERE b.therapist_id = $therapist_id
        ORDER BY b.booking_date DESC";
$appointments = $conn->query($sql);

// Fetch messages from customers for this therapist
$chat_sql = "SELECT um.id, c.name AS customer_name, um.message, um.status, um.created_at
             FROM user_messages um
             JOIN customers c ON c.id = um.customer_id
             WHERE um.therapist_id = $therapist_id
             ORDER BY um.created_at DESC";
$messages = $conn->query($chat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Therapist Dashboard</title>
<style>
body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
.container { max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h2 { color: #00aaff; text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 20px;}
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
th { background: #00aaff; color: #fff;}
tr:hover { background: #f1f1f1;}
textarea { width: 100%; padding: 8px; margin-top:5px; border-radius:5px; border:1px solid #ccc;}
button { padding: 8px 12px; background:#00aaff; color:#fff; border:none; border-radius:5px; cursor:pointer;}
button:hover { background:#008ecc;}
.message { color: green; text-align:center; }
.reply-form { margin-top:10px; }
</style>
</head>
<body>

<div class="container">
<h2>Welcome, <?= htmlspecialchars($therapist_name); ?></h2>

<?php if($message) echo "<p class='message'>$message</p>"; ?>

<h3>Appointments</h3>
<?php if($appointments->num_rows > 0): ?>
<table>
<tr>
<th>#</th>
<th>Customer</th>
<th>Email</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
</tr>
<?php $count=1; while($row = $appointments->fetch_assoc()): ?>
<tr>
<td><?= $count++; ?></td>
<td><?= htmlspecialchars($row['customer_name']); ?></td>
<td><?= htmlspecialchars($row['email']); ?></td>
<td><?= htmlspecialchars($row['service']); ?></td>
<td><?= $row['booking_date']; ?></td>
<td><?= $row['booking_time']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No appointments found.</p>
<?php endif; ?>

<h3>Messages from Customers</h3>
<?php if($messages->num_rows > 0): ?>
<table>
<tr>
<th>#</th>
<th>Customer</th>
<th>Message</th>
<th>Status</th>
<th>Sent On</th>
<th>Reply</th>
</tr>
<?php $count=1; while($row = $messages->fetch_assoc()): ?>
<tr>
<td><?= $count++; ?></td>
<td><?= htmlspecialchars($row['customer_name']); ?></td>
<td><?= nl2br(htmlspecialchars($row['message'])); ?></td>
<td><?= htmlspecialchars($row['status']); ?></td>
<td><?= $row['created_at']; ?></td>
<td>
<?php if($row['status'] === 'pending'): ?>
<form class="reply-form" method="POST">
<input type="hidden" name="message_id" value="<?= $row['id']; ?>">
<textarea name="reply_message" placeholder="Type your reply..." required></textarea>
<button type="submit" name="reply">Send Reply</button>
</form>
<?php else: ?>
<p>Replied</p>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No messages found.</p>
<?php endif; ?>

<button onclick="window.location.href='logout.php'">Logout</button>
</div>

</body>
</html>
