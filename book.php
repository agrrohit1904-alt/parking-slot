<?php
header('Content-Type: application/json');
require_once '../db.php';

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['slot_id']) || !isset($data['name']) || !isset($data['plate'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$slot_id = (int)$data['slot_id'];
$name = trim($data['name']);
$plate = trim($data['plate']);

if (empty($name) || empty($plate)) {
    echo json_encode(['success' => false, 'message' => 'Name and License Plate cannot be empty.']);
    exit;
}

try {
    // Check if slot is already booked
    $stmt = $pdo->prepare("SELECT status FROM slots WHERE id = ?");
    $stmt->execute([$slot_id]);
    $slot = $stmt->fetch();
    
    if (!$slot) {
        echo json_encode(['success' => false, 'message' => 'Slot not found.']);
        exit;
    }
    
    if ($slot['status'] === 'booked') {
        echo json_encode(['success' => false, 'message' => 'Slot is already booked!']);
        exit;
    }
    
    // Book the slot
    $update = $pdo->prepare("UPDATE slots SET status = 'booked', booked_by = ?, license_plate = ?, booking_time = NOW() WHERE id = ?");
    $update->execute([$name, $plate, $slot_id]);
    
    echo json_encode(['success' => true, 'message' => 'Slot booked successfully!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
