<?php
session_start();
require 'db.php'; // your PDO connection

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id']; // logged in customer
$service     = $_POST['booking_service'] ?? '';
$booking_date = $_POST['booking_date'] ?? '';
$booking_time = $_POST['booking_time'] ?? '';

// Map therapist by service (hardcoded mapping)
$therapists = [
    'Ayurveda'      => 2, // use the actual ID of Ayurveda therapist in customers table
    'Yoga'          => 3, // replace with real therapist user.id
    'Nutrition'     => 4, // replace with real therapist user.id
    'Physiotherapy' => 5, // replace with real therapist user.id
];

// Assign therapist_id based on selected service
$therapist_id = $therapists[$service] ?? null;

// Validate
if (empty($service) || empty($booking_date) || empty($booking_time) || !$therapist_id) {
    die("Invalid booking request.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO bookings 
        (customer_id, therapist_id, service, booking_date, booking_time) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$customer_id, $therapist_id, $service, $booking_date, $booking_time]);

      echo "<script>showBookingSuccess();</script>";
} else {
    echo "<script>alert('Booking failed. Please try again.');</script>";

} catch (Exception $e) {
    echo "Error saving booking: " . $e->getMessage();
}
try {
    $stmt = $pdo->prepare("INSERT INTO bookings 
        (customer_id, therapist_id, service, booking_date, booking_time) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$customer_id, $therapist_id, $service, $booking_date, $booking_time]);

    // Respond with JSON
    echo json_encode([
        'status' => 'success',
        'message' => 'Booking successful!'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error saving booking: ' . $e->getMessage()
    ]);
}

