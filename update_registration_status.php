<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','therapist'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = in_array($_POST['status'], ['registered','cancelled']) ? $_POST['status'] : 'registered';
    $stmt = $pdo->prepare("UPDATE registrations SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $id]);
}

header("Location: manage_registrations.php");
