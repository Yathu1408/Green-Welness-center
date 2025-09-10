<?php
session_start();
require 'db.php';

if(!isset($_SESSION['customer_id'])) {
    exit("Not logged in");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id'];
    $service = $_POST['service'] ?? '';
    $booking_date = $_POST['booking_date'] ?? '';
    $booking_time = $_POST['booking_time'] ?? '';

    // Map service to therapist_id
    $therapists = [
        'Ayurveda' => 2,  // replace with real legal ID / user ID
        'Yoga' => 3,
        'Nutrition' => 4,
        'Physiotherapy' => 5
    ];
    $therapist_id = $therapists[$service] ?? 0;

    if(!$therapist_id) {
        exit("Invalid service selected");
    }

    // Insert booking
    $stmt = $pdo->prepare("INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$customer_id, $therapist_id, $service, $booking_date, $booking_time])) {
        echo "success";
    } else {
        echo "Error saving booking";
    }
}
?>
