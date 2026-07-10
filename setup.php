<?php
// setup.php
// This script creates the database and tables if they don't exist.

$host = '127.0.0.1';
$user = 'root';
$pass = ''; // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS parking_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE parking_db");
    
    // Create slots table
    $pdo->exec("CREATE TABLE IF NOT EXISTS slots (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slot_number VARCHAR(10) NOT NULL UNIQUE,
        status ENUM('available', 'booked') DEFAULT 'available',
        booked_by VARCHAR(255) DEFAULT NULL,
        license_plate VARCHAR(50) DEFAULT NULL,
        booking_time DATETIME DEFAULT NULL
    )");
    
    // Insert default slots (A1 to A10 and B1 to B10) if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM slots");
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT INTO slots (slot_number) VALUES (:num)");
        for ($i = 1; $i <= 10; $i++) {
            $insert->execute(['num' => "A$i"]);
            $insert->execute(['num' => "B$i"]);
        }
        echo "<h2>Successfully created 20 default parking slots.</h2><br>";
    }
    
    echo "<h3>Database setup completed successfully!</h3> <p>You can now use the application. <a href='index.php'>Go to Home</a></p>";
    
} catch (\PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
