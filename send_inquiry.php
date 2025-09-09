<?php
session_start();
require 'db.php'; // your PDO connection

header('Content-Type: application/json');

// ✅ Ensure logged-in user
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["success" => false, "message" => "You must log in to send inquiries."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id']; // this should be users.id
    $type    = $_POST['type'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!$type || !$subject || !$message) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO inquiries (customer_id, type, subject, message) 
                               VALUES (:customer_id, :type, :subject, :message)");
        $ok = $stmt->execute([
            ':customer_id' => $customer_id,
            ':type' => $type,
            ':subject' => $subject,
            ':message' => $message
        ]);

        if ($ok) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to send inquiry."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
