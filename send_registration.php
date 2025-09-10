<?php
session_start();

// Check login status
$isLoggedIn   = isset($_SESSION['customer_id']); 
$customerName = $_SESSION['customer_name'] ?? '';
$userRole     = $_SESSION['role'] ?? 'guest';

header('Content-Type: application/json');
require 'db.php'; // make sure $pdo is a working PDO connection

// Only logged-in customers can register
if (!$isLoggedIn) {
    // return JSON indicating the client should prompt for login
    echo json_encode(["success" => false, "message" => "You must log in to register for a programme.", "redirect" => "login.php"]);
    exit;
}

// Proceed with POST handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['customer_id']; // this must be users.id
    $programme_id = isset($_POST['programme_id']) ? intval($_POST['programme_id']) : 0;

    if (!$programme_id) {
        echo json_encode(["success" => false, "message" => "Invalid programme selected."]);
        exit;
    }

    try {
        // Prevent duplicate registration for same user/programme (optional but useful)
        $check = $pdo->prepare("SELECT id FROM registrations WHERE user_id = :user_id AND programme_id = :programme_id LIMIT 1");
        $check->execute([':user_id' => $user_id, ':programme_id' => $programme_id]);
        if ($check->fetch()) {
            echo json_encode(["success" => false, "message" => "You are already registered for this programme."]);
            exit;
        }

        // Insert registration
        $stmt = $pdo->prepare("INSERT INTO registrations (user_id, programme_id) VALUES (:user_id, :programme_id)");
        $ok = $stmt->execute([':user_id' => $user_id, ':programme_id' => $programme_id]);

        if ($ok) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to save registration."]);
        }
    } catch (PDOException $e) {
        // return error message (for debugging; remove message in production)
        echo json_encode(["success" => false, "message" => "DB error: " . $e->getMessage()]);
    }
    exit;
}

// if not POST
echo json_encode(["success" => false, "message" => "Invalid request."]);
