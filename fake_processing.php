<?php
session_start();
if (!isset($_GET["id"])) {
    header("Location: user_dashboard.php");
    exit;
}
$bookingId = (int)$_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Processing Payment...</title>

<style>
body {
  background: #f2fff8;
  font-family: "Poppins", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.loader-box {
  background: #ffffff;
  padding: 45px 55px;
  border-radius: 22px;
  text-align: center;
  box-shadow: 0 12px 35px rgba(0,0,0,0.18);
}

.spinner {
  width: 75px;
  height: 75px;
  border: 7px solid #c8f5e4;
  border-top: 7px solid #2c786c;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 18px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

h2 {
  font-size: 24px;
  color: #0e4635;
  margin-bottom: 6px;
}
p { color:#444; font-size: 16px; opacity:.8; }
.dot {
    animation: blink 1.5s infinite;
}

@keyframes blink{
    0%,20% { opacity: .2; }
    50% { opacity: 1; }
    100%{ opacity: .2; }
}
</style>

<script>
// ✅ Auto redirect after 4s + play success sound
setTimeout(() => {
  const audio = document.getElementById("successSound");
  audio.play();
}, 3500);

setTimeout(() => {
  window.location.href = "payment_success.php?id=<?= $bookingId ?>";
}, 5000);
</script>
</head>
<body>

<div class="loader-box">
  <div class="spinner"></div>
  <h2>Processing Payment</h2>
  <p>Please wait<span class="dot">...</span></p>
</div>

<!-- ✅ Success sound -->
<audio id="successSound" preload="auto">
  <source src="https://assets.mixkit.co/active_storage/sfx/2000/2000-preview.mp3" type="audio/mpeg">
</audio>

</body>
</html>
