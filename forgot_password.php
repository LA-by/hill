<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if ($email === "") {
        $error = "Please enter your email.";
    } else {
        // ✅ Check email exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // ✅ Store user ID in session
            $_SESSION['reset_user_id'] = $user['id'];

            // ✅ Redirect to reset password page
            header("Location: reset_password.php");
            exit;
        } else {
            $error = "Email not registered!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-box">
<h2>Forgot Password?</h2>

<?php if ($error): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
  <div class="input-box">
    <label>Email</label>
    <input type="email" name="email" required placeholder="Enter your registered email">
  </div>

  <div class="input-box">
    <input type="submit" value="CONTINUE">
  </div>

  <div class="links">
    <a href="login.php">Back to Login</a>
  </div>
</form>
</div>

</body>
</html>
