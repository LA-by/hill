<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$error = "";
$success = "";
$prefillEmail = "";

// Handle registration
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $prefillEmail = $email;

    // ✅ Basic validation
    if ($name === "" || $email === "" || $phone === "" || $password === "") {
        $error = "All fields are required!";
    } 
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone must be 10 digits!";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } 
    elseif (!preg_match("/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/", $password)) {
        $error = "Password does not meet requirements!";
    } else {
        // ✅ Check if email already exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // ✅ Handle profile photo upload
            $photoName = "default.png";

            if (!empty($_FILES["photo"]["name"])) {
                $uploadDir = "uploads/";
                if (!is_dir($uploadDir)) mkdir($uploadDir);

                $fileName = time() . "_" . basename($_FILES["photo"]["name"]);
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                    $photoName = $fileName;
                }
            }

            // ✅ Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // ✅ Insert user
            $stmt = $mysqli->prepare("
                INSERT INTO users (name, email, phone, password_hash, photo, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $photoName);
            $stmt->execute();

            $success = "✅ Registration successful! Redirecting...";
            $_SESSION["prefill_email"] = $email;

            // ✅ Redirect after 2 seconds
            header("refresh:2; url=login.php");
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

body {
  height:100vh; display:flex; justify-content:center; align-items:center;
  background:radial-gradient(#1e9e8c, rgba(0,0,0,0.3));
}

.register-box {
  width:400px; background:#5ed1a9; padding:40px; border-radius:20px;
  text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.3);
  animation:float 6s ease-in-out infinite;
}

@keyframes float {
  0%,100%{transform:translateY(0)}
  50%{transform:translateY(-8px)}
}

h2 { margin-bottom:20px; font-size:2rem; font-weight:800; }

.input-box { text-align:left; margin-bottom:15px; }

.input-box label { display:block; font-weight:600; }

.input-box input {
  width:100%; padding:12px; border-radius:25px; border:none;
  background:rgba(255,255,255,0.3); outline:none;
}

.input-box input:focus {
  border:2px solid #ff9f43; box-shadow:0 0 10px orange;
}

.password-rules { font-size:.85rem; margin-bottom:10px; }
.password-rules span { display:block; }

.valid { color:green; font-weight:600; }
.invalid { color:red; font-weight:600; }

#registerBtn {
  width:100%; padding:12px; border:none; border-radius:25px;
  background:linear-gradient(45deg,#ff9f43,#ff6b6b); color:white;
  font-weight:800; font-size:1rem; cursor:pointer;
  transition:.3s;
}

#registerBtn:hover { transform:scale(1.05); }

.shake {
  animation:shake .3s ease-in-out;
}

@keyframes shake {
  0%,100%{transform:translateX(0)}
  25%{transform:translateX(-6px)}
  75%{transform:translateX(6px)}
}

.error, .success {
  padding:10px; border-radius:12px; margin-bottom:12px;
  font-weight:600;
}

.error { background:#ffb3b3; color:#8b0000; }
.success { background:#b6ffb3; color:#084d00; }
</style>
</head>

<body>
<div class="register-box">

<h2>Create Account</h2>

<?php if($error): ?>
  <div class="error"><?= $error ?></div>
<?php endif; ?>

<?php if($success): ?>
  <div class="success"><?= $success ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" id="regForm">

  <div class="input-box">
    <label>Name</label>
    <input type="text" name="name" required>
  </div>

  <div class="input-box">
    <label>Email</label>
    <input type="email" name="email" required value="<?= htmlspecialchars($prefillEmail) ?>">
  </div>

  <div class="input-box">
    <label>Phone</label>
    <input type="text" name="phone" maxlength="10" required>
  </div>

  <div class="input-box">
    <label>Password</label>
    <input type="password" name="password" id="password" required>
  </div>

  <div class="password-rules">
    <span id="len" class="invalid">❌ Minimum 6 characters</span>
    <span id="cap" class="invalid">❌ At least 1 Capital Letter</span>
    <span id="sym" class="invalid">❌ At least 1 Symbol</span>
  </div>

  <div class="input-box">
    <label>Profile Photo (optional)</label>
    <input type="file" name="photo" accept="image/*">
  </div>

  <button type="submit" id="registerBtn">Register ✅</button>

  <p style="margin-top:10px;">Already have an account? <a href="login.php">Login</a></p>

</form>
</div>

<script>
const pass = document.getElementById("password");
const len = document.getElementById("len");
const cap = document.getElementById("cap");
const sym = document.getElementById("sym");
const btn = document.getElementById("registerBtn");
const form = document.getElementById("regForm");

pass.addEventListener("input", () => {
  let p = pass.value;

  p.length >= 6 ? valid(len) : invalid(len);
  /[A-Z]/.test(p) ? valid(cap) : invalid(cap);
  /[\W_]/.test(p) ? valid(sym) : invalid(sym);
});

form.addEventListener("submit", (e) => {
  if (document.querySelectorAll(".invalid").length > 0) {
    e.preventDefault();
    btn.classList.add("shake");
    setTimeout(() => btn.classList.remove("shake"), 500);
  }
});

function valid(x) { x.classList.add("valid"); x.classList.remove("invalid"); x.textContent = "✅ " + x.textContent.slice(2); }
function invalid(x) { x.classList.add("invalid"); x.classList.remove("valid"); x.textContent = "❌ " + x.textContent.slice(2); }
</script>

</body>
</html>
