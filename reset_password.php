<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$error = "";
$message = "";

// ✅ Check user reached this page legally
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit;
}

$user_id = $_SESSION['reset_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);

    if ($pass === "" || $confirm === "") {
        $error = "All fields are required.";
    } elseif ($pass !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        // ✅ Update DB
        $update = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $update->bind_param("si", $hashed, $user_id);
        $update->execute();

        // ✅ Remove session
        unset($_SESSION['reset_user_id']);

        $message = "✅ Password changed successfully! <a href='login.php'>Login Now</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-box">
<h2>Reset Password</h2>

<?php if ($error): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<?php if ($message): ?>
<p style="color:green;"><?= $message ?></p>
<?php else: ?>

<form method="POST">
  <div class="input-box">
    <label>New Password</label>
    <input type="password" name="password" required placeholder="Enter new password">
  </div>

  <div class="input-box">
    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required placeholder="Confirm password">
  </div>

  <div class="input-box">
    <input type="submit" value="RESET PASSWORD">
  </div>
</form>
<?php endif; ?>
</div>

</body>
</html>
