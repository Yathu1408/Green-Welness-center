<?php 
session_start();
require 'db.php'; // include your database connection

$errorMsg = ''; // to store any error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $legalid = $_POST['legalid'];
    $phone = $_POST['phone'];
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    try {
        // Insert into DB
        $stmt = $pdo->prepare("INSERT INTO customers (name, legalid, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $legalid, $phone, $email, $password]);

        $_SESSION['customer_id'] = $pdo->lastInsertId();
        $_SESSION['customer_name'] = $name;

        echo "<script>
            window.parent.postMessage({ type: 'authSuccess', name: '".addslashes($name)."' }, '*');
        </script>";
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $errorMsg = "This Legal ID is already registered. Please login or use different information.";
        } else {
            $errorMsg = "An unexpected error occurred. Please try again later.";
        }
    }
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

    <?php if ($errorMsg): ?>
        <div style="color:red; margin-bottom:10px;"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="text" name="legalid" placeholder="NIC / PP" required />
        <input type="phone" name="phone" placeholder="Mobile" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Signup</button>
    </form>
    <p>
        Already have an account? 
        <a href="#" onclick="window.parent.postMessage('showLogin','*'); return false;">Login</a>
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

/* Heading */
h2 {
    color: #ff7300ff;
    margin-top:-16px;
    margin-bottom:10px
    font-size: 25px;
}

/* Form layout */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Inputs */
input[type="text"],
input[type="phone"],
input[type="email"],
input[type="password"] {
    width: 80%;
    max-width: 300px;
    padding: 10px 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.97); /* semi-transparent */
    outline: none;
    font-size: 14px;
    transition: all 0.3s ease;
}

/* Input focus effect */
input[type="text"]:focus,
input[type="phone"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #16653d;
    background: rgba(255, 255, 255, 0.4);
}

/* Button */
button {
    width: 80%;
    max-width: 300px;
    padding: 10px 15px;
    border: none;
    margin-top: 10px;
    border-radius: 25px;
    background-color: #16653d;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

/* Button hover */
button:hover {
    background-color: #fb8600ff;
}

/* Links */
p a {
    color: #fc8200ff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

p a:hover {
    color: #03652cff;
}
</style>
</body>
</html>
