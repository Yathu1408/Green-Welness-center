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

// Fetch all users
$sql = "SELECT id, name, legalid, phone, email, role, created_at FROM customers ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - View Users</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f9; margin:0; padding:0; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    h2 { color: #00aaff; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px;}
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #00aaff; color: #fff;}
    tr:hover { background: #f1f1f1;}
    button { padding: 8px 15px; background: #00aaff; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top:10px;}
    button:hover { background: #008ecc; }
</style>
</head>
<body>

<div class="container">
    <h2>All Registered Users</h2>

    <?php if($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Legal ID</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered On</th>
            </tr>
            <?php $count = 1; while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['legalid']); ?></td>
                <td><?= htmlspecialchars($row['phone']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= ucfirst($row['role']); ?></td>
                <td><?= $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No users registered yet.</p>
    <?php endif; ?>

    <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
