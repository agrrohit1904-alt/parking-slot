<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ParkFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="logo" style="font-size: 2rem;">ParkFlow Admin</div>
        <div>
            <a href="index.php" class="btn btn-secondary" style="margin-right: 10px; text-decoration: none;">Public View</a>
            <a href="api/admin-auth.php?logout=1" class="btn btn-secondary" style="text-decoration: none;">Logout</a>
        </div>
    </header>

    <main class="dashboard">
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Slots</h3>
                <p id="stat-total">-</p>
            </div>
            <div class="stat-card">
                <h3>Booked</h3>
                <p id="stat-booked" style="color: var(--booked);">-</p>
            </div>
            <div class="stat-card">
                <h3>Available</h3>
                <p id="stat-avail" style="color: var(--available);">-</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Slot Management</h2>
            <table id="bookings-table">
                <thead>
                    <tr>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Booked By</th>
                        <th>License Plate</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Injected by JS -->
                </tbody>
            </table>
        </div>
    </main>

    <script src="assets/admin.js"></script>
</body>
</html>
