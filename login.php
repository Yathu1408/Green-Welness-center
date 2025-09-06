<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['customer_id'] = $user['id'];
        $_SESSION['customer_name'] = $user['name'];

        echo "<script>
            window.parent.postMessage({ type: 'authSuccess', name: '".addslashes($user['name'])."' }, '*');
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
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required /><br><br>
        <input type="password" name="password" placeholder="Password" required /><br><br>
        <button type="submit">Login</button>
    </form>
    <p>
        Don't have an account? 
        <a href="#" onclick="window.parent.postMessage('showRegister','*'); return false;">Signup</a>
    </p>

    <style>
    /* Make the iframe content transparent */
    body {
        background: transparent;
        text-align: center;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #ff7300ff;
        margin-bottom: 20px;
        font-size: 30px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input[type="email"], input[type="password"] {
        width: 80%;
        max-width: 300px;
        padding: 10px 15px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.97); /* semi-transparent */
        outline: none;
        transition: all 0.3s ease;
    }

    input[type="email"]:focus, input[type="password"]:focus {
        border-color: #16653d;
        background: rgba(255, 255, 255, 0.4);
    }

    button {
        width: 80%;
        max-width: 300px;
        padding: 10px 15px;
        border: none;
        border-radius: 25px;
        background-color: #16653d;
        color: #fff;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background-color: #fb8600ff;
    }

    p a {
        color: #fc8200ff;
        text-decoration: none;
        font-weight: bold;
    }

    p a:hover {
        color: #03652cff;
    }
</style>
</body>
</html>
