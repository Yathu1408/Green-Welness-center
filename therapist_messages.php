<?php
session_start();
require 'db.php'; // database connection

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist'){
    header("Location: index.php");
    exit();
}

$therapist_name = $_SESSION['name'];

// Map services to therapists
$service_to_therapist = [
    'Massage' => 'Therapist 1',
    'Yoga' => 'Therapist 2',
    'Meditation' => 'Therapist 3',
    'Wellness Consultation' => 'Therapist 4'
];

// Get services assigned to this therapist
$services_for_therapist = array_keys(array_filter($service_to_therapist, function($t) use ($therapist_name) {
    return $t === $therapist_name;
}));

if(empty($services_for_therapist)){
    $services_for_therapist = ['']; // Avoid SQL error
}

$services_str = "'" . implode("','", $services_for_therapist) . "'";

// Handle reply submission
if (isset($_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $reply_text = $_POST['reply_text'];

    $stmt = $conn->prepare("UPDATE user_messages SET message = CONCAT(message, '\n\nTherapist Reply: ', ?), status='replied' WHERE id=?");
    $stmt->bind_param("si", $reply_text, $message_id);
    $stmt->execute();
    $success = "Reply sent successfully!";
}

// Fetch messages
$sql = "SELECT um.id, c.name AS customer_name, c.email, um.subject, um.message, um.created_at
        FROM user_messages um
        JOIN bookings b ON b.customer_id = um.customer_id
        JOIN customers c ON c.id = um.customer_id
        WHERE b.service IN ($services_str)
        ORDER BY um.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Messages | Therapist</title>
<style>
body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
.container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h2 { color: #00aaff; text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 20px;}
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top;}
th { background: #00aaff; color: #fff;}
tr:hover { background: #f1f1f1;}
textarea { width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;}
button { padding: 8px 15px; background: #00aaff; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top:5px;}
button:hover { background: #008ecc; }
.success { color: green; text-align:center; }
form { margin-top: 10px; }
</style>
</head>
<body>

<div class="container">
    <h2>Customer Messages</h2>

    <?php if(isset($success)) echo "<p class='success'>{$success}</p>"; ?>

    <?php if($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message / Reply</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['customer_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['subject']); ?></td>
                <td>
                    <?= nl2br(htmlspecialchars($row['message'])); ?>
                    <form method="post">
                        <input type="hidden" name="message_id" value="<?= $row['id']; ?>">
                        <textarea name="reply_text" rows="2" placeholder="Type your reply..." required></textarea>
                        <button type="submit" name="reply">Send Reply</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No messages found.</p>
    <?php endif; ?>

    <button onclick="window.location.href='therapist_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
