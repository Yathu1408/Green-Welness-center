<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example: Save user to DB (replace with actual DB logic)
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy registration success
    $_SESSION['customer_id'] = 2;
    $_SESSION['customer_name'] = $name;

    // Notify parent window
    echo "<script>
        window.parent.postMessage({ type: 'authSuccess', name: '".addslashes($name)."' }, '*');
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required /><br><br>
    <input type="email" name="email" placeholder="Email" required /><br><br>
    <input type="password" name="password" placeholder="Password" required /><br><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="#" onclick="window.parent.postMessage('showLogin','*'); return false;">Login here</a></p>
</body>
</html>
