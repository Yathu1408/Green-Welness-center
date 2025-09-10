<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

// Get filter/search inputs
$roleFilter = $_GET['role'] ?? '';
$search = $_GET['search'] ?? '';

// Prepare base SQL
$sql = "SELECT id, name, legalid, phone, email, role, created_at FROM users WHERE 1";
$params = [];

// Apply role filter
if($roleFilter && $roleFilter !== 'all') {
    $sql .= " AND role = :role";
    $params[':role'] = $roleFilter;
}

// Apply search filter
if($search) {
    $sql .= " AND (name LIKE :search OR email LIKE :search OR legalid LIKE :search)";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

// Prepare and execute statement safely
$stmt = $pdo->prepare($sql);
$stmt->execute($params);  // Pass parameters array directly
$users = $stmt->fetchAll();

// Fetch all unique roles for dropdown
$rolesStmt = $pdo->query("SELECT DISTINCT role FROM users");
$roles = $rolesStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - View Users</title>
<style>
body {  
    background: #d7d7d7c3; 
    margin:0; 
    padding:0;
 }
.container { 
    max-width: 1000px; 
    margin: 40px auto; 
    background: #fff; 
    padding: 30px;
    border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.23);
}
h2 {
     color: #ff9500ff; 
     text-align: center; 
    }
table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 20px;
}
th, td { 
    padding: 12px; 
    border-bottom: 1px solid #ddd; 
    text-align: left;
 }
th { 
    background: #004b00ff;
     color: #ffffffff;}
tr:hover {
     background: #945c0032;}

button { 
    padding: 8px 15px; 
    background: #ff7700ff; 
    color: #fff;
     border: none; 
     border-radius: 5px; 
     cursor: pointer; 
     margin-top:10px;}
button:hover { 
    background: #003402ff;
 }
.filters {
     margin-bottom: 20px; 
    }
.filters select, .filters input[type="text"] { padding: 6px; margin-right: 10px; border-radius: 4px; border: 1px solid #ccc; }
.filters button { padding: 6px 12px; }
</style>
</head>
<body>

<div class="container">
    <h2>All Registered Users</h2>

    <!-- Filters -->
    <form method="get" class="filters">
        <select name="role">
            <option value="all">All Roles</option>
            <?php foreach($roles as $role): ?>
                <option value="<?= htmlspecialchars($role) ?>" <?= ($role === $roleFilter) ? 'selected' : '' ?>>
                    <?= ucfirst($role) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="search" placeholder="Search by name, email or legal ID" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Filter</button>
        <button type="button" onclick="window.location.href='view_users.php'">Reset</button>
    </form>

    <?php if(count($users) > 0): ?>
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
            <?php $count = 1; foreach($users as $row): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['legalid']); ?></td>
                <td><?= htmlspecialchars($row['phone']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= ucfirst($row['role']); ?></td>
                <td><?= $row['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No users found.</p>
    <?php endif; ?>

    <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
