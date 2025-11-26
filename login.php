<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$error = "";

// ✅ Get pre-filled login details after registration
$prefill_email = $_SESSION['prefill_email'] ?? "";
$prefill_pass  = $_SESSION['prefill_pass'] ?? "";

// ✅ When form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === "" || $password === "") {
        $error = "All fields are required.";
    } else {
        // ✅ Query DB — use correct column name "password"
        $stmt = $mysqli->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // ✅ Verify hashed password
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // ✅ Clear autofill session
                unset($_SESSION['prefill_email'], $_SESSION['prefill_pass']);

                // ✅ Redirect to dashboard
                header("Location: user_dashboard.php");
                exit;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "No user found with this email!";
        }
    }
}

// ✅ After displaying, clear prefill so it doesn’t stay forever
unset($_SESSION['prefill_email'], $_SESSION['prefill_pass']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Hill Sagar</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
  <link rel="stylesheet" href="login.css">
</head>
<body>

  <div class="login-box">
    <h2 style="font-style: italic; font-weight: 900;">Welcome to Hill Sagar</h2>

    <!-- Show error message -->
    <?php if ($error != ""): ?>
      <div id="errorMsg" style="color:red; margin-bottom:10px;">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="input-box">
        <label for="email">Email</label>
        <input type="email"
               name="email"
               id="email"
               placeholder="Enter your email"
               required
               value="<?= htmlspecialchars($prefill_email) ?>">
      </div>

      <div class="input-box">
        <label for="password">Password</label>
        <input type="password"
               name="password"
               id="password"
               placeholder="Enter your password"
               required
               value="<?= htmlspecialchars($prefill_pass) ?>">

        <div class="show-password">
          <input type="checkbox" id="showPass" />
          <label for="showPass">Show Password</label>
        </div>
      </div>

      <div class="input-box">
        <input type="submit" value="LOGIN">
      </div>

      <div class="links">
        <a href="forgot_password.php">Forgot Password?</a>
        <a href="register.php">Sign up</a>
        <a href="dashboard_admin/admin_login.php">Admin Login</a>
      </div>

      <p class="or">OR LOGIN WITH</p>
      <div class="social-login">
        <a href="#"><img src="https://img.icons8.com/color/48/000000/google-logo.png"></a>
        <a href="#"><img src="https://img.icons8.com/color/48/000000/facebook-new.png"></a>
      </div>
    </form>
  </div>

  <script>
    // ✅ Show password toggle
    document.getElementById('showPass').addEventListener('change', function() {
      let passField = document.getElementById('password');
      passField.type = this.checked ? 'text' : 'password';
    });
  </script>

</body>
</html>
