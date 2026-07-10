<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ParkFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .login-container {
            margin-top: 100px;
            background: var(--bg-card);
            padding: 40px;
            border-radius: 24px;
            width: 400px;
            max-width: 90vw;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            text-align: center;
        }
        .error-msg {
            color: #ef4444;
            margin-bottom: 15px;
            font-size: 0.9rem;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">ParkFlow Admin</div>
    </header>

    <div class="login-container">
        <h3 style="margin-bottom: 25px; font-size: 1.5rem;">Secure Access</h3>
        <p class="error-msg" id="error-msg"></p>
        <form id="login-form">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px;">Login</button>
        </form>
        <p style="margin-top: 20px; font-size: 0.9rem;">
            <a href="index.php" style="color: var(--accent); text-decoration: none;">&larr; Back to Public Page</a>
        </p>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append('username', document.getElementById('username').value);
            formData.append('password', document.getElementById('password').value);

            const res = await fetch('api/admin-auth.php', { method: 'POST', body: formData });
            const data = await res.json();

            if (data.success) {
                window.location.href = 'admin.php';
            } else {
                const err = document.getElementById('error-msg');
                err.textContent = data.message;
                err.style.display = 'block';
            }
        });
    </script>
</body>
</html>
