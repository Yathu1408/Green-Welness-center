<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','therapist'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $response = $_POST['response'];

    $stmt = $pdo->prepare("UPDATE inquiries 
                           SET response = :response, status='answered', responded_at = NOW() 
                           WHERE id = :id");
    $stmt->execute([':response' => $response, ':id' => $id]);

    header("Location: manage_inquiries.php");
}
