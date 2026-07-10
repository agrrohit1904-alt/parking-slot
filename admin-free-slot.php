<?php
session_start();
header('Content-Type: application/json');
require_once '../db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['slot_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing slot ID']);
    exit;
}

$slot_id = (int)$data['slot_id'];

try {
    $update = $pdo->prepare("UPDATE slots SET status = 'available', booked_by = NULL, license_plate = NULL, booking_time = NULL WHERE id = ?");
    $update->execute([$slot_id]);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
