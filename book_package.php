<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
requireUserLogin();

// ✅ Get package id safely
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ✅ Fetch package details
$pkgStmt = $mysqli->prepare("SELECT id, title, price, duration, image, description, state, package_type FROM packages WHERE id=?");
$pkgStmt->bind_param("i", $id);
$pkgStmt->execute();
$pkg = $pkgStmt->get_result()->fetch_assoc();
$pkgStmt->close();

// ✅ If package not found → redirect
if (!$pkg) redirect("packages.php");

$message = "";

// ✅ Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $travelDate = sanitize($_POST["travel_date"] ?? "");
    $travelers = (int)($_POST["travelers"] ?? 1);
    $contactPhone = sanitize($_POST["contact_phone"] ?? "");
    $specialRequests = sanitize($_POST["special_requests"] ?? "");
    $paymentMethod = sanitize($_POST["payment_method"] ?? "Cash on Arrival");

    // ✅ Validation
    if ($travelDate === "" || $travelers < 1 || $contactPhone === "") {
        $message = "⚠ Please fill all required fields.";
    } else {

        // ✅ Insert booking with payment columns
        $stmt = $mysqli->prepare("
            INSERT INTO bookings
            (user_id, destination, state, package_type, phone, travelers, travel_start_date, special_requests, payment_method, payment_status, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Pending')
        ");

        $stmt->bind_param(
            "isssissss",
            $_SESSION['user_id'],
            $pkg['title'],
            $pkg['state'],
            $pkg['package_type'],
            $contactPhone,
            $travelers,
            $travelDate,
            $specialRequests,
            $paymentMethod
        );

        $stmt->execute();
        $bookingId = $mysqli->insert_id; // ✅ Get last inserted booking id
        $stmt->close();

        // ✅ Updated success message with payment button
        $message = "
        ✅ Booking request received!<br>
        ⏳ Status: Pending Confirmation<br><br>
        <a href='fake_payment.php?id=$bookingId' 
        style='padding:12px 20px;background:#2c786c;color:white;border-radius:10px;text-decoration:none;font-weight:bold;'>
        Proceed to Payment
        </a>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book: <?php echo htmlspecialchars($pkg["title"]); ?> - HillSagar</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="main.css">

<style>
.booking-container {
    max-width: 850px;
    margin: 40px auto;
    padding: 24px;
    background: rgba(255,255,255,.9);
    border-radius: 20px;
    box-shadow: var(--shadow);
}
.package-info {
    background: linear-gradient(263deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 22px;
    border-radius: 15px;
    margin-bottom: 28px;
}
.form-group { margin-bottom: 18px; }
.form-group label { font-weight: 600; margin-bottom: 6px; display: block; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 12px;
    border-radius: 10px; border: 1px solid #ccc;
    font-size: 16px;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
.btn-book {
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
    padding: 15px 26px;
    border-radius: 30px;
    border: none;
    color: white;
    font-weight: 700;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    transition: .3s;
}
.btn-book:hover { transform: translateY(-2px); }
.message {
    background: #28a745;
    color: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 1.1rem;
}
</style>
</head>
<body>

<header class="main-header">
  <div class="navbar container">

    <div class="slogan">
      <p style="font-size: xx-large;color:black;text-decoration: underline overline;"><strong>Hill Sagar</strong></p>
      Where Mountains Meet the Sea
    </div>

    <nav class="nav-links">
      <ul>
        <li><a href="#hills">Hill Stations</a></li>
        <li><a href="#beaches">Beaches</a></li>
        <li><a href="#featured">Destinations</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="contact.php">Contact</a></li>

        <?php if (!isUserLoggedIn()): ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php else: ?>
          <li><a href="user_home.php">My Page</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>


<div class="booking-container">

    <a href="packages.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Packages</a>

    <div class="package-info">
        <h2><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($pkg["title"]) ?></h2>
        <p><strong>Duration:</strong> <?= htmlspecialchars($pkg["duration"]) ?></p>
        <p><strong>Price:</strong> ₹<?= htmlspecialchars($pkg["price"]) ?> per person</p>
        <p><strong>About:</strong> <?= htmlspecialchars($pkg["description"]) ?></p>
    </div>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">

        <div class="form-row">
            <div class="form-group">
                <label>Travel Date *</label>
                <input type="date" name="travel_date" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="form-group">
                <label>Travelers *</label>
                <select name="travelers" required>
                    <option value="1">1 Person</option>
                    <option value="2">2 People</option>
                    <option value="3">3 People</option>
                    <option value="4">4 People</option>
                    <option value="5">5 People</option>
                    <option value="6">6+ People</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Contact Phone *</label>
            <input type="tel" name="contact_phone" required placeholder="+91 9876543210">
        </div>

        <div class="form-group">
            <label>Payment Method *</label>
            <select name="payment_method" required>
                <option value="Cash on Arrival">Cash on Arrival (Pay at Hotel)</option>
                <option value="UPI">UPI</option>
                <option value="Credit/Debit Card">Credit/Debit Card</option>
            </select>
        </div>

        <div class="form-group">
            <label>Special Requests</label>
            <textarea name="special_requests" rows="4" placeholder="Anything we should know?"></textarea>
        </div>

        <button type="submit" class="btn-book">
            <i class="fas fa-check-circle"></i> Submit Booking Request
        </button>
    </form>

</div>
</body>
</html>
