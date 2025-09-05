<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// DB connection
$conn = new mysqli("localhost", "db_user", "db_pass", "db_name");
$stmt = $conn->prepare("SELECT name, email, phone FROM customers WHERE id=?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking</title>
</head>
<body>
<h2>Booking</h2>
<form action="process_booking.php" method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo $customer['name']; ?>" readonly><br><br>
    
    <label>Email</label>
    <input type="email" name="email" value="<?php echo $customer['email']; ?>" readonly><br><br>
    
    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo $customer['phone']; ?>" readonly><br><br>
    
    <label>Date</label>
    <input type="date" name="booking_date" required><br><br>
    
    <label>Time</label>
    <input type="time" name="booking_time" required><br><br>
    
    <button type="submit">Confirm Booking</button>
</form>
</body>
</html>
