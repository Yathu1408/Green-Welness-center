<?php
// saveMessage.php
header("Content-Type: application/json");

// DB connection
$servername = "localhost";
$username = "root";   // default XAMPP username
$password = "";       // default XAMPP has no password
$dbname = "greenlife_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed."]));
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

$user_id = 1; // Example: Replace with logged-in user ID
$subject = $conn->real_escape_string($data["subject"]);
$message = $conn->real_escape_string($data["message"]);

// Insert into user_messages
$sql1 = "INSERT INTO user_messages (customer_id , subject, message) 
         VALUES ('$customer_id ', '$subject', '$message')";

// Insert into admin_messages
$sql2 = "INSERT INTO admin_messages (customer_id, subject, message) 
         VALUES ('$customer_id ', '$subject', '$message')";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Message saved successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>