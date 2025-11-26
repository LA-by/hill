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
<title>Payment Successful ✅</title>

<style>
body {
    background: #e6fff4;
    font-family: "Poppins", sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.box {
    background: white;
    padding: 45px 55px;
    border-radius: 22px;
    text-align: center;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
    animation: pop 0.6s ease-out;
}

@keyframes pop {
  0% { transform: scale(0.6); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

.checkmark {
  width: 85px;
  height: 85px;
  border-radius: 50%;
  border: 6px solid #18b36b;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 18px;
  animation: bounce 0.6s ease-out 0.3s forwards;
  opacity: 0;
}

.checkmark i {
  color: #18b36b;
  font-size: 45px;
}

@keyframes bounce {
  0% { transform: scale(0.4); opacity: 0; }
  60% { transform: scale(1.18); opacity: 1; }
  100% { transform: scale(1); }
}

h2 {
  color: #045c41;
  font-size: 28px;
  margin-bottom: 6px;
}

p {
  color: #333;
  font-size: 16px;
}

.btn {
  display: inline-block;
  margin-top: 22px;
  padding: 12px 22px;
  background: #2c786c;
  color: white;
  text-decoration: none;
  border-radius: 10px;
  font-weight: bold;
  transition: 0.3s;
}

.btn:hover {
  background: #004445;
}

.confetti {
  position: fixed;
  width: 12px;
  height: 12px;
  background: red;
  top: -20px;
  animation: fall linear forwards;
}

@keyframes fall {
  to {
    transform: translateY(110vh) rotate(600deg);
  }
}
</style>
<script>
// ✅ Confetti generator
function createConfetti() {
  for (let i = 0; i < 80; i++) {
    const c = document.createElement("div");
    c.classList.add("confetti");
    c.style.left = Math.random() * 100 + "vw";
    c.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`;
    c.style.animationDuration = Math.random() * 2 + 2 + "s";
    document.body.appendChild(c);

    setTimeout(() => c.remove(), 4000);
  }
}

window.onload = () => {
  createConfetti();

  // ✅ Auto redirect to dashboard after 4 seconds
  setTimeout(() => {
    window.location.href = "user_dashboard.php";
  }, 4000);
};
</script>

</head>
<body>

<div class="box">
  <div class="checkmark">
    <i class="fas fa-check"></i>
  </div>
  <h2>Payment Successful ✅</h2>
  <p>Your booking has been confirmed!</p>
  <p><strong>Booking ID: #<?= $bookingId ?></strong></p>

  <a href="user_dashboard.php" class="btn">Go to Dashboard</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
