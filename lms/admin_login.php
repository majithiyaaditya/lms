<?php
// admin_login.php - Admin login form and logic
// This file lets an admin log in using their username and password

session_start();
require_once 'db.php';

$username = $password = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $message = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $db_password);
            $stmt->fetch();
            if ($password == $db_password) {
                $_SESSION["admin_id"] = $id;
                $_SESSION["admin_username"] = $username;
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "No admin found with that username.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-card">
  <!-- Left: Illustration -->
  <div class="login-illustration">
  <img src="img/img1.png" alt="LMS Illustration">
  </div>
  <!-- Right: Login Form -->
  <div class="login-form-section">
    <h2>Login</h2>
    <form class="login-form" method="post" action="">
      <div class="input-group">
        <input type="text" name="username" placeholder="Your Name" value="<?php echo htmlspecialchars($username); ?>" required>
        <span class="input-icon">&#128100;</span>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
        <span class="input-icon">&#128274;</span>
      </div>
      <div class="login-options">
        <label><input type="checkbox" name="remember"> Remember me</label>
      </div>
      <input type="submit" value="Log in">
      <?php if ($message) { echo '<p style="color:red">' . $message . '</p>'; } ?>
    </form>
    <!-- <div class="social-login">
      <button class="social-btn facebook" title="Login with Facebook">f</button>
      <button class="social-btn twitter" title="Login with Twitter">t</button>
      <button class="social-btn google" title="Login with Google">G</button>
    </div> -->
    <a class="create-account-link" href="admin_register.php">Create an account</a>
  </div>
</div>
</body>
</html> 