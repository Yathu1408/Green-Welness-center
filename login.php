<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example: Validate credentials (replace with your DB logic)
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy check for demonstration (replace with DB check)
    if ($email === 'test@example.com' && $password === '12345') {
        $_SESSION['customer_id'] = 1;
        $_SESSION['customer_name'] = 'John Doe';

        // Notify parent window
        echo "<script>
            window.parent.postMessage({ type: 'authSuccess', name: 'John Doe' }, '*');
        </script>";
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required /><br><br>
    <input type="password" name="password" placeholder="Password" required /><br><br>
    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="#" onclick="window.parent.postMessage('showRegister','*'); return false;">Register here</a></p>
</body>
</html>
