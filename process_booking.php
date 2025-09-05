<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];

// DB connection
$conn = new mysqli("localhost", "db_user", "db_pass", "db_name");

$stmt = $conn->prepare("INSERT INTO bookings (customer_id, booking_date, booking_time) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $customer_id, $booking_date, $booking_time);

if ($stmt->execute()) {
    echo "<p>Booking successful!</p><a href='index.php'>Back to Services</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>
