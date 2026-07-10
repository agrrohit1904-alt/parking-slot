<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded credentials for simplicity
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../admin-login.php");
    exit;
}
?>
