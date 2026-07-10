<?php
session_start();
header('Content-Type: application/json');
require_once '../db.php';

// Very basic auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['error' => 'Unauthorized']);
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
