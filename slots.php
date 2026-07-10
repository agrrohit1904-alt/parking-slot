<?php
header('Content-Type: application/json');
require_once '../db.php';

if (!isset($pdo)) {
    echo json_encode(['error' => 'Database connection failed. Did you run setup.php?']);
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM slots ORDER BY id ASC");
    $slots = $stmt->fetchAll();
    echo json_encode($slots);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
