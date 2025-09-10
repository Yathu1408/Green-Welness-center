<?php
session_start();
require 'db.php';

// Only allow admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = '';

// Handle form submission
if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Generate a unique legalid
    $legalid = uniqid('user_'); // e.g., user_64f123abc

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $message = "Email already exists. Please use another email.";
    } else {
        // Insert new user with legalid
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, legalid) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $password, $role, $legalid])) {
            $message = "New $role account created successfully!";
        } else {
            $message = "Error creating account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Admin/Therapist</title>
<style>
    
    body { 
         background: #f4f4f9;
          margin:0;
          padding:0; 
        }
    .container {
        max-width: 500px;
        margin: 60px auto;
        background: #fff; 
        padding: 30px; 
        border-radius: 10px; 
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { 
        color: #ff8400ff;
        text-align: center; 
        margin-bottom: 20px; 
    }
    input, select { 
        width: 100%; 
        padding: 10px; 
        margin: 10px 0; 
        border-radius: 5px; 
        border: 1px solid #ccc; 
    }
    button { 
        width: 100%; 
        padding: 10px; 
        background: #ff8800ff; 
        color: #fff; 
        border: none; 
        border-radius: 10px; 
        cursor: pointer;
     }
    button:hover {
         background: #147500ff;
         }
    .message { 
        text-align: center; margin-bottom: 15px; color: green;
         }
</style>
</head>
<body>

<div class="container">
    <h2>Create Admin / Therapist Account</h2>

    <?php if($message) echo "<p class='message'>$message</p>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="therapist">Therapist</option>
        </select>
        <button type="submit">Create Account</button>
    </form>

    <button style="margin-top:10px;" onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
</div>

</body>
</html>
