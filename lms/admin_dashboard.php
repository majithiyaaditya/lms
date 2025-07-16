<?php
// admin_dashboard.php - Simple admin dashboard
// This page is shown after a successful login

// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"])) {
    // If not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>!</h2>
    <p>You are now logged in as admin.</p>
    <a href="logout.php">Logout</a>
</body>
</html> 