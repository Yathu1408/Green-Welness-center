<?php 

session_start();
if (!isset($_SESSION[""])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Greenlife Wellness Center</title>
    <link rel="stylesheet" href="style.css">
</head>

<body> style="background: #fff;">
     <div class= "Admin Home">
        <H1> Greenlife Wellness Center Admin, <span><?= $_SESSION['name']; ?></span></H1>
        <button onclick="window.location.href='logout.php'">Continue</button>
    </div>
     
</body>
</html>