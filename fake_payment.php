<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
requireUserLogin();

// ✅ Get booking ID safely
$bookingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ✅ Fetch booking & package price
$stmt = $mysqli->prepare("
    SELECT b.id, b.user_id, b.destination, b.travelers, b.payment_status, b.payment_method, 
           p.price
    FROM bookings b
    JOIN packages p ON p.title = b.destination
    WHERE b.id=? AND b.user_id=?
");
$stmt->bind_param("ii", $bookingId, $_SESSION['user_id']);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();

// ✅ If booking not found → redirect
if (!$booking) redirect("fake_processing.php?id=$bookingId");

// ✅ Total Amount
$totalAmount = $booking['price'] * $booking['travelers'];

// ✅ Handle Fake Payment Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $update = $mysqli->prepare("
        UPDATE bookings 
        SET payment_status='Paid', status='Confirmed' 
        WHERE id=? AND user_id=?
    ");
    $update->bind_param("ii", $bookingId, $_SESSION['user_id']);
    $update->execute();
    $update->close();

  redirect("payment_success.php?id=$bookingId");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fake Payment • HillSagar</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f7f6;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 550px;
    margin: 50px auto;
    background: white;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-align: center;
}
h2 {
    color: #2c786c;
}
.amount-box {
    background: #e9fff7;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 22px;
    font-size: 1.25rem;
    font-weight: bold;
}
button {
    padding: 12px 22px;
    background: #2c786c;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1.1rem;
    cursor: pointer;
    font-weight: bold;
    transition: .3s;
}
button:hover {
    background: #004445;
    transform: scale(1.04);
}
.back {
    display: block;
    margin-top: 18px;
    text-decoration: none;
    color: #444;
}
.back:hover {
    text-decoration: underline;
}
.payment-logo {
    width: 80px;
    margin-bottom: 15px;
}
</style>

</head>
<body>

<div class="container">

    <img src="images/payment.png" class="payment-logo" alt="Pay">

    <h2>Complete Payment</h2>
    <p><strong>Destination:</strong> <?= htmlspecialchars($booking['destination']) ?></p>
    <p><strong>Travelers:</strong> <?= (int)$booking['travelers'] ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($booking['payment_method']) ?></p>

    <div class="amount-box">
        Total Amount: ₹<?= number_format($totalAmount) ?>
    </div>

    <?php if ($booking['payment_status'] === "Paid"): ?>
        <p style="color:green; font-weight:bold;">✅ Payment Already Completed</p>
        <a href="user_dashboard.php" class="back">Go Back</a>
    <?php else: ?>
        <form method="post">
            <button type="submit">Pay Now</button>
        </form>
        <a href="user_dashboard.php" class="back">Cancel</a>
    <?php endif; ?>
</div>

</body>
</html>
