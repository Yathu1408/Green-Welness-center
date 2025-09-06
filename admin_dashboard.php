<?php 
session_start();

// Role-based session check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Greenlife Wellness Center</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .admin-home {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #ff7300;
            text-align: center;
        }
        h1 span {
            color: #333;
        }
        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 30px 0;
        }
        nav ul li {
            background: #ff7300;
            padding: 15px 25px;
            border-radius: 8px;
            transition: 0.3s;
            margin: 5px;
        }
        nav ul li:hover {
            background: #e65c00;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        button {
            display: block;
            margin: 20px auto 0 auto;
            padding: 12px 25px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div class="admin-home">
        <h1>Greenlife Wellness Center Admin, <span><?= htmlspecialchars($_SESSION['name']); ?></span></h1>

        <nav>
            <ul>
                <li><a href="view_users.php">View Users</a></li>
                <li><a href="view_bookings.php">View Appointments</a></li>
                <li><a href="view_messages.php">View Messages</a></li>
                <li><a href="create_user.php">Create Admin/Therapist</a></li>
                <li><a href="view_programs.php">Program Registrations</a></li>
            </ul>
        </nav>

        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
