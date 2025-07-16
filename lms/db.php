<?php
// db.php - Database connection file
// This file connects to the MySQL database named 'lms'.

// Database credentials
$servername = "localhost"; // Server name (usually 'localhost')
$username = "root";        // Database username (default is 'root' in XAMPP)
$password = "";            // Database password (default is empty in XAMPP)
$dbname = "lms";           // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// If you see no error, connection is successful!
?> 