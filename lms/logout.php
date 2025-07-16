<?php
// logout.php - Admin logout script
// This file logs out the admin and redirects to the login page

// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit(); 