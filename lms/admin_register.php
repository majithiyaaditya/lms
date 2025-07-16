<?php
// admin_register.php - Admin registration form and logic
// This file lets a new admin register by creating a username and password

require_once 'db.php';

$full_name = $username = $email = $phone = $password = $message = "";
$message_type = ""; // 'success' or 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);

    // Simple validation
    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_type = "error";
    } elseif (!empty($phone) && !preg_match('/^[6-9]\d{9}$/', $phone)) {
        $message = "Please enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.";
        $message_type = "error";
    } else {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Username or email already exists. Please choose another.";
            $message_type = "error";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO admin (full_name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $full_name, $username, $email, $phone, $password);
            if ($stmt->execute()) {
                $message = "Registration successful! You can now <a href='admin_login.php'>login</a>.";
                $message_type = "success";
            } else {
                $message = "Error: Could not register.";
                $message_type = "error";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-card">
  <!-- Left: Illustration -->
  <div class="login-illustration">
    <img src="img/img1.png" alt="LMS Illustration">
  </div>
  <!-- Right: Registration Form -->
  <div class="login-form-section">
    <h2>Sign up</h2>
    <form class="login-form" method="post" action="">
      <div class="input-group">
        <input type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($full_name); ?>" required>
        <span class="input-icon">&#128100;</span>
      </div>
      <div class="input-group">
        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
        <span class="input-icon">&#128273;</span>
      </div>
      <div class="input-group">
        <input type="email" name="email" placeholder="example@email.com" value="<?php echo htmlspecialchars($email); ?>" required>
        <span class="input-icon">&#9993;</span>
      </div>
      <div class="input-group">
        <input type="text" name="phone" placeholder="9876543210" value="<?php echo htmlspecialchars($phone); ?>">
        <span class="input-icon">&#128222;</span>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
        <span class="input-icon">&#128274;</span>
      </div>
      <input type="submit" value="Register">
      <?php if ($message) { ?>
        <p class="<?php echo $message_type === 'success' ? 'success-message' : 'error-message'; ?>"><?php echo $message; ?></p>
      <?php } ?>
    </form>
    <a class="create-account-link" href="admin_login.php">Already registered? Login here</a>
  </div>
</div>
</body>
</html> 