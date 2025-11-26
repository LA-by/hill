<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';
requireUserLogin();

$userId = (int)$_SESSION['user_id'];
$message = '';

// ✅ Fetch wishlist booking IDs of logged-in user
$wstmt = $mysqli->prepare("SELECT booking_id FROM wishlist WHERE user_id=?");
$wstmt->bind_param("i", $userId);
$wstmt->execute();
$wres = $wstmt->get_result();
$wishlist = [];
while ($w = $wres->fetch_assoc()) {
    $wishlist[] = $w['booking_id'];
}
$wstmt->close();

/* ✅ LOAD USER INFO (with avatar_style) */
$ustmt = $mysqli->prepare('SELECT name, email, phone, photo, avatar_style, created_at FROM users WHERE id=?');
$ustmt->bind_param('i', $userId);
$ustmt->execute();
$user = $ustmt->get_result()->fetch_assoc();
$ustmt->close();

if (!$user) {
    die("User not found");
}

/* ✅ LIVE PROFILE UPDATE (AJAX) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_profile') {
    header('Content-Type: application/json');

    $name  = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $avatarStyle = $_POST['avatar_style'] ?? 'circle';
    $photoFile = $_FILES['photo'] ?? null;
    $photoName = $user['photo'];

    // Allow only known avatar styles
    $allowedAvatarStyles = ['circle', 'gold-ring'];
    if (!in_array($avatarStyle, $allowedAvatarStyles, true)) {
        $avatarStyle = 'circle';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
        exit;
    }

    if ($photoFile && !empty($photoFile['tmp_name'])) {
        $upload = uploadImage($photoFile, __DIR__ . '/uploads');
        if ($upload['success']) {
            $photoName = $upload['path'];
            $_SESSION['user_photo'] = $photoName;
        } else {
            echo json_encode(['success' => false, 'message' => $upload['error']]);
            exit;
        }
    }

    $stmt = $mysqli->prepare('UPDATE users SET name=?, email=?, phone=?, photo=?, avatar_style=? WHERE id=?');
    $stmt->bind_param('sssssi', $name, $email, $phone, $photoName, $avatarStyle, $userId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user_name']  = $name;
    $_SESSION['user_email'] = $email;

    echo json_encode([
        'success'       => true,
        'message'       => 'Profile updated successfully ✅',
        'name'          => $name,
        'email'         => $email,
        'phone'         => $phone,
        'photo'         => $photoName,
        'avatar_style'  => $avatarStyle
    ]);
    exit;
}

/* ✅ CANCEL BOOKING */
if (isset($_GET['cancel'])) {
    $bid = (int)$_GET['cancel'];
    $stmt = $mysqli->prepare('UPDATE bookings SET status="Cancelled by User" WHERE id=? AND user_id=?');
    $stmt->bind_param('ii', $bid, $userId);
    $stmt->execute();
    $stmt->close();
    $message = 'Booking cancelled ✅';
}

/* ✅ USER BOOKINGS */
$bookings = $mysqli->prepare('
    SELECT id, destination, state, package_type, travel_start_date, travel_end_date,
           travelers, hotel_type, transport, special_requests, status, created_at
    FROM bookings
    WHERE user_id = ?
    ORDER BY id DESC
');
$bookings->bind_param('i', $userId);
$bookings->execute();
$bres = $bookings->get_result();
$bookings->close();

// Current avatar style
$currentAvatarStyle = $user['avatar_style'] ?? 'circle';
$allowedStyles = ['circle', 'gold-ring'];
if (!in_array($currentAvatarStyle, $allowedStyles, true)) {
    $currentAvatarStyle = 'circle';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hill Sagar Dashboard</title>

<style>
:root {
    --primary-color: #2c786c;
    --secondary-color: #004445;
    --accent-color: #fab700;
    --light-color: rgba(255, 255, 255, 0.8);
    --dark-color: rgba(19, 30, 36, 0.8);
    --text-color: #000000;
    --white: rgba(255, 255, 255, 0.9);
    --gray-light: rgba(245, 245, 245, 0.6);
    --gray: rgba(224, 224, 224, 0.5);
    --font-main: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    
    --bg-color: rgba(245, 245, 247, 0.8);
    --card-bg: rgba(255, 255, 255, 0.5);
    --text-primary: #090909;
    --header-bg: rgba(255, 255, 255, 0.7);
    --footer-bg: #69d3c4;
    --nav-color: var(--primary-color);
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    --border-radius: 16px;
    --border: 1px solid rgba(255, 255, 255, 0.5);
    --backdrop: blur(10px);
}

.dark-theme {
    --primary-color: #3a9e8f;
    --secondary-color: #00564d;
    --accent-color: #ffc53d;
    --light-color: rgba(26, 26, 26, 0.8);
    --dark-color: rgba(76, 62, 62, 0.8);
    --text-color: rgba(224, 224, 224, 0.9);
    --white: rgba(105, 195, 252, 0.8);
    --gray-light: rgba(42, 42, 42, 0.6);
    --gray: rgba(68, 68, 68, 0.5);
    
    --bg-color:#4b7871;
    --card-bg: rgba(30, 30, 30, 0.5);
    --text-primary: rgba(255, 255, 255, 0.9);
    --header-bg: rgba(30, 30, 30, 0.7);
    --footer-bg: rgb(69, 75, 75);
    --nav-color: rgba(66, 63, 63, 0.9);
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    --border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Reset + Global */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: var(--font-main);
}

body {
    background: var(--bg-color);
    color: var(--text-primary);
}

/* Header */
header {
    background: var(--header-bg);
    padding: 25px 40px;
    text-align: center;
    box-shadow: var(--shadow);
}

header h1 {
    color: var(--primary-color);
    font-size: 2.6rem;
    font-weight: 800;
}

header p {
    color: var(--accent-color);
    font-size: 1.15rem;
    font-weight: 600;
}

/* Navbar (original style) */
nav {
    background: var(--nav-color);
    padding: 14px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: opacity 0.3s ease;
}

nav a:hover {
    opacity: 0.7;
}

/* Alert Box (used for profile + wishlist etc.) */
#alertBox {
    position: fixed;
    top: 25px;
    right: 25px;
    background: var(--primary-color);
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: 600;
    display: none;
    z-index: 9999;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    animation: slideIn .5s ease;
}

@keyframes slideIn {
    from { transform: translateX(120%); opacity: 0; }
    to   { transform: translateX(0); opacity: 1; }
}

/* Layout */
.container {
    display: flex;
    gap: 25px;
    padding: 40px;
}

.sidebar,
.card {
    background: var(--card-bg);
    padding: 22px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    backdrop-filter: var(--backdrop);
    border: var(--border);
}

.sidebar {
    flex: 1;
}

.content {
    flex: 3;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Profile */
.profile {
    text-align: center;
    margin-bottom: 18px;
}

/* Avatar base */
.avatar-img {
    width: 115px;
    height: 115px;
    object-fit: cover;
    margin-bottom: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease, border 0.3s ease;
}

/* Style 1: Simple circle */
.avatar-circle {
    border-radius: 50%;
    border: 3px solid var(--primary-color);
}

/* Style 4: Gold ring premium */
.avatar-gold-ring {
    border-radius: 50%;
    border: 4px solid #FFD700;
    box-shadow: 0 0 0 3px rgba(245, 197, 66, 0.4), 0 10px 28px rgba(0,0,0,0.3);
}

/* Avatar style options (radio) */
.avatar-style-options {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-top: 8px;
}

.avatar-style-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 0.8rem;
    cursor: pointer;
}

.avatar-style-option input {
    display: none;
}

.avatar-preview {
    width: 42px;
    height: 42px;
    background-size: cover;
    background-position: center;
    margin-bottom: 4px;
    transition: transform .2s ease, box-shadow .2s ease, border .2s ease;
}

/* preview circle */
.avatar-preview-circle {
    border-radius: 50%;
    border: 2px solid var(--primary-color);
}

/* preview gold ring */
.avatar-preview-gold-ring {
    border-radius: 50%;
    border: 2px solid #f5c542;
    box-shadow: 0 0 0 2px rgba(245, 197, 66, 0.4);
}

.avatar-style-option input:checked + .avatar-preview {
    transform: scale(1.08);
    box-shadow: 0 0 0 3px rgba(44,120,108,0.4);
}

/* Forms */
form label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 8px;
}

input,
select,
textarea {
    width: 100%;
    padding: 10px 12px;
    margin: 6px 0 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
    outline: none;
    transition: border 0.3s ease, background 0.3s ease, color 0.3s ease, transform 0.15s ease;
}

input:focus,
textarea:focus,
select:focus {
    border: 1px solid var(--primary-color);
    transform: translateY(-1px);
}

/* Buttons */
button {
    padding: 8px 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    transition: transform 0.2s ease, opacity 0.2s ease, box-shadow 0.2s ease;
}

button:hover {
    transform: translateY(-1px) scale(1.03);
    box-shadow: 0 6px 18px rgba(0,0,0,0.20);
}

button:active {
    transform: scale(0.97);
    box-shadow: none;
}

button.update {
    background: var(--primary-color);
    color: white;
}

button.delete {
    background: #d62828;
    color: white;
}

/* Table */
.packages table {
    width: 100%;
    border-collapse: collapse;
}

.packages th,
.packages td {
    padding: 14px;
    border-bottom: 1px solid #ddd;
    font-size: 0.95rem;
}

.packages tr:hover {
    background: var(--gray-light);
}

.packages th {
    background: var(--accent-color);
    color: white;
    font-size: 0.95rem;
    text-align: left;
}

/* Status Badges */
.status-pending,
.status-confirmed,
.status-cancelled,
.status-cancelled-by-user {
    padding: 6px 12px;
    font-size: 0.85rem;
    border-radius: 14px;
    font-weight: 600;
    display: inline-block;
}

.status-pending { background: #ffca2c; color: #533f03; }
.status-confirmed { background: #28a745; color: white; }
.status-cancelled { background: #dc3545; color: white; }
.status-cancelled-by-user { background: #b3202b; color: white; }

/* Messages */
.message {
    background: #28a745;
    padding: 13px;
    font-size: 1rem;
    color: white;
    border-radius: 8px;
    text-align: center;
    width: 90%;
    margin: 22px auto;
}

/* Footer */
.footer {
    text-align: center;
    padding: 22px;
    background: var(--footer-bg);
    margin-top: 40px;
    color: white;
    font-weight: 600;
}

/* ✅ Dark Mode Button */
.theme-toggle {
    background: white;
    color: #000;
    border: none;
    padding: 8px 16px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 700;
    transition: background 0.4s ease, opacity 0.4s ease, transform 0.4s ease;
}

.theme-toggle:hover {
    transform: scale(1.1);
}

.theme-toggle.rotate {
    transform: rotate(360deg);
}

/* Smooth Theme Transition */
body, nav, header, .card, .sidebar, .footer, table, td, th {
    transition: background-color 0.6s ease, color 0.6s ease, border-color 0.6s ease;
}

/* ✅ Timeline UI in Modal */
.timeline {
    display: flex;
    justify-content: space-between;
    margin: 18px 0;
    position: relative;
}
.timeline::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 4%;
    width: 92%;
    height: 4px;
    background: #ccc;
    z-index: 1;
}
.timeline-step {
    position: relative;
    z-index: 2;
    width: 18px;
    height: 18px;
    background: #bbb;
    border-radius: 50%;
}
.timeline-step.active {
    background: var(--primary-color);
}
.timeline-step.cancelled {
    background: #d62828;
}

/* ✅ Modal */
#bookingModal {
    position: fixed;
    top: 0;
    left: 0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.55);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
    backdrop-filter: blur(4px);
}
#bookingModal .modal-inner {
    background: var(--card-bg);
    padding: 28px;
    width: 420px;
    max-width: 95%;
    border-radius: 18px;
    box-shadow: var(--shadow);
    animation: fadeIn 0.35s ease;
}
#modalContent {
    line-height: 1.6;
    font-size: 0.95rem;
}

@keyframes fadeIn {
    from { opacity:0; transform:scale(0.92); }
    to   { opacity:1; transform:scale(1); }
}

/* ✅ Mobile UI */
@media (max-width: 900px) {
    .container {
        flex-direction: column;
        padding: 20px;
    }

    nav {
        padding: 12px 20px;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    nav > div:first-child {
        margin-bottom: 8px;
    }
}
</style>
</head>

<body>
<header>
    <h1>Hill Sagar</h1>
    <p>Where mountains meet sea</p>
</header>

<nav>
    <div style="font-size: x-large; font-weight: 800;">Dashboard</div>

    <div>
        <a href="index.php">Home</a>
        <a href="user_home.php">My Page</a>
        <a href="index.php">Packages</a>
        <a href="logout.php">Logout</a>
    </div>

    <button id="themeToggle" class="theme-toggle">🌙</button>
</nav>

<!-- ✅ Global popup alert (profile + wishlist + booking) -->
<div id="alertBox"></div>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="container">
    <aside class="sidebar">
        <div class="profile">
            <?php
                $avatarClass = ($currentAvatarStyle === 'gold-ring') ? 'avatar-gold-ring' : 'avatar-circle';
                $photoPath = (!empty($user['photo']) && file_exists('uploads/' . $user['photo']))
                    ? 'uploads/' . $user['photo']
                    : 'images/avatar.png';
            ?>
            <img id="displayPhoto"
                 src="<?= htmlspecialchars($photoPath) ?>"
                 alt="Profile"
                 class="avatar-img <?= $avatarClass ?>">

            <h2 id="displayName"><?= htmlspecialchars($user['name']) ?></h2>
            <p id="displayEmail"><?= htmlspecialchars($user['email']) ?></p>
            <p id="displayPhone"><?= htmlspecialchars($user['phone']) ?></p>

            <!-- Small hint -->
            <p style="font-size:0.8rem; opacity:0.7; margin-top:4px;">Click style below & save profile</p>

            <!-- Avatar style selector -->
            <div class="avatar-style-options">
                <!-- Style 1: Circle -->
                <label class="avatar-style-option">
                    <input type="radio"
                           name="avatar_style_choice"
                           value="circle"
                           <?= $currentAvatarStyle === 'circle' ? 'checked' : '' ?>>
                    <div class="avatar-preview avatar-preview-circle"
                         style="background-image:url('<?= htmlspecialchars($photoPath) ?>');"></div>
                    <span>Circle</span>
                </label>

                <!-- Style 4: Gold Ring -->
                <label class="avatar-style-option">
                    <input type="radio"
                           name="avatar_style_choice"
                           value="gold-ring"
                           <?= $currentAvatarStyle === 'gold-ring' ? 'checked' : '' ?>>
                    <div class="avatar-preview avatar-preview-gold-ring"
                         style="background-image:url('<?= htmlspecialchars($photoPath) ?>');"></div>
                    <span>Gold Ring</span>
                </label>
            </div>
        </div>

        <div class="card">
            <h3>Update Profile</h3>
            <form id="profileForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <!-- hidden real avatar value -->
                <input type="hidden" name="avatar_style" id="avatarStyleInput" value="<?= $currentAvatarStyle ?>">

                <label>Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

                <label>Phone:</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

                <label>Photo:</label>
                <input type="file" name="photo" accept="image/*">

                <button type="submit" class="update">Update</button>
                <p id="updateMsg" style="margin-top:8px;font-weight:600;"></p>
            </form>
        </div>
    </aside>

    <section class="content">
        <div class="card packages">
            <h3>Your Bookings</h3>

            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Destination</th>
                        <th>Dates</th>
                        <th>Travelers</th>
                        <th>Hotel / Transport</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($bres->num_rows > 0): ?>
                    <?php while ($row = $bres->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if ($row['status'] === 'Confirmed'): ?>
                                    <a href="generate_invoice.php?id=<?= $row['id'] ?>" 
                                       target="_blank" 
                                       style="color:green; font-weight:bold;">
                                       ✅ Download Invoice
                                    </a>
                                <?php else: ?>
                                    <span style="color:#a10000; font-weight:600;">
                                        ⏳ Awaiting Confirmation
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?= htmlspecialchars($row['destination']) ?></strong><br>
                                <small><?= htmlspecialchars(str_replace('_', ' ', $row['package_type'])) ?></small>
                            </td>

                            <td>
                                <?= date('M d, Y', strtotime($row['travel_start_date'])) ?>
                                -
                                <?= date('M d, Y', strtotime($row['travel_end_date'])) ?>
                            </td>

                            <td><?= (int)$row['travelers'] ?> person(s)</td>

                            <td>
                                <?= htmlspecialchars($row['hotel_type']) ?><br>
                                <?= htmlspecialchars($row['transport']) ?>
                            </td>

                            <td>
                                <span class="status-<?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>

                            <td>
                                <?php $fav = in_array($row['id'], $wishlist); ?>

                                <!-- ❤️ Wishlist Button -->
                                <span class="fav-btn"
                                    onclick="toggleWishlist(<?= $row['id'] ?>, this)"
                                    style="cursor:pointer;font-size:22px;margin-right:8px;">
                                    <?= $fav ? '❤️' : '🤍' ?>
                                </span>

                                <!-- Cancel button if pending -->
                                <?php if ($row['status'] === 'Pending'): ?>
                                    <button class="delete" onclick="cancelBooking(<?= (int)$row['id'] ?>)">Cancel</button>
                                <?php endif; ?>

                                <!-- View Booking Details -->
                                <button class="update"
                                    onclick='viewDetails(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                    View
                                </button>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center">No bookings found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="footer">&copy; 2025 Hill Sagar — All Rights Reserved</div>

<!-- ✅ Booking Details Modal -->
<div id="bookingModal">
    <div class="modal-inner">
        <h2 style="text-align:center;margin-bottom:15px;color:var(--primary-color);">
            Booking Details
        </h2>
        <div id="modalContent"></div>
        <button onclick="closeModal()"
                style="margin-top:18px;width:100%;padding:10px;
                       background:var(--primary-color);color:#fff;
                       border:none;border-radius:10px;font-size:1rem;
                       font-weight:600;cursor:pointer;">
            Close
        </button>
    </div>
</div>

<script>
// Cancel booking
function cancelBooking(id) {
    if (confirm("Are you sure you want to cancel this booking?")) {
        window.location.href = "?cancel=" + id;
    }
}

// Escape HTML
function escapeHtml(str) {
    if (!str) return "";
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

function formatDate(dateStr) {
    let d = new Date(dateStr);
    if (isNaN(d)) return dateStr;
    return d.toLocaleDateString("en-IN", { day:"2-digit", month:"short", year:"numeric" });
}

// VIEW DETAILS → Modal + timeline + countdown
function viewDetails(b) {
    let modal = document.getElementById("bookingModal");
    let content = document.getElementById("modalContent");

    modal.style.display = "flex";

    let today    = new Date();
    let tripDate = new Date(b.travel_start_date);
    let diffDays = Math.ceil((tripDate - today) / (1000 * 60 * 60 * 24));

    let countdownMsg =
        diffDays > 0  ? `${diffDays} day(s) left ✅` :
        diffDays === 0 ? "Your trip starts today 🎉" :
                         "Trip completed ✅";

    let confirmed = (b.status === "Confirmed");
    let cancelled = b.status.toLowerCase().includes("cancelled");
    let processing = (b.status === "Pending");

    let timeline = `
        <div class="timeline">
            <div class="timeline-step active"></div>
            <div class="timeline-step ${processing || confirmed || cancelled ? 'active' : ''}"></div>
            <div class="timeline-step ${
                confirmed ? 'active' : cancelled ? 'cancelled' : ''
            }"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:10px;">
            <span>Booked</span>
            <span>Processing</span>
            <span>${cancelled ? "Cancelled" : "Confirmed"}</span>
        </div>
    `;

    let cancelBtn = "";
    if (b.status === "Pending") {
        cancelBtn = `
            <button onclick="cancelFromModal(${b.id})"
                style="margin-top:12px;width:100%;padding:10px;background:#d62828;
                color:white;border:none;border-radius:10px;font-size:1rem;font-weight:600;">
                Cancel Booking ❌
            </button>`;
    }

    content.innerHTML = `
        ${timeline}

        <strong>Destination:</strong> ${escapeHtml(b.destination)}, ${escapeHtml(b.state)}<br>
        <strong>Package:</strong> ${escapeHtml(b.package_type).replace(/_/g, " ")}<br>
        <strong>Travel:</strong> ${formatDate(b.travel_start_date)} → ${formatDate(b.travel_end_date)}<br>
        <strong>Countdown:</strong> ${countdownMsg}<br>
        <strong>Travelers:</strong> ${escapeHtml(b.travelers)}<br>
        <strong>Hotel:</strong> ${escapeHtml(b.hotel_type)}<br>
        <strong>Transport:</strong> ${escapeHtml(b.transport)}<br>
        <strong>Status:</strong> ${escapeHtml(b.status)}<br>
        <strong>Booked on:</strong> ${formatDate(b.created_at)}<br><br>
        <strong>Special Requests:</strong><br>
        ${b.special_requests ? escapeHtml(b.special_requests) : "<em>No requests provided</em>"}
        ${cancelBtn}
    `;
}

function closeModal() {
    document.getElementById("bookingModal").style.display = "none";
}

function cancelFromModal(id) {
    if (!confirm("Are you sure you want to cancel this booking?")) return;
    fetch("?cancel=" + id)
        .then(() => location.reload());
}

document.addEventListener("click", function(e) {
    let modal = document.getElementById("bookingModal");
    if (e.target === modal) modal.style.display = "none";
});

// Global alert popup
function showAlert(msg){
    let box = document.getElementById("alertBox");
    box.textContent = msg;
    box.style.display = "block";
    setTimeout(() => {
        box.style.display = "none";
    }, 2200);
}

// WISHLIST TOGGLE
function toggleWishlist(id, el){
    let action = el.textContent.trim() === "🤍" ? "add" : "remove";

    fetch("wishlist.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `booking_id=${id}&action=${action}`
    })
    .then(r => r.json())
    .then(data => {
        if(data.success){
            el.textContent = action === "add" ? "❤️" : "🤍";
            showAlert(action === "add"
                ? "Added to Wishlist ❤️"
                : "Removed from Wishlist ❌"
            );
        }
    });
}

// If any confirmed booking, show info once (simple)
if (document.querySelector(".status-confirmed")) {
    showAlert("🎉 Your booking has been confirmed!");
}

// DARK MODE TOGGLE
const themeToggleBtn = document.getElementById('themeToggle');

function applySavedTheme() {
    try {
        const savedTheme = localStorage.getItem('hill_sagar_theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
            themeToggleBtn.textContent = '☀️';
        } else {
            document.body.classList.remove('dark-theme');
            themeToggleBtn.textContent = '🌙';
        }
    } catch (e) {}
}

themeToggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    const isDark = document.body.classList.contains('dark-theme');
    themeToggleBtn.textContent = isDark ? '☀️' : '🌙';
    themeToggleBtn.classList.add("rotate");
    setTimeout(()=> themeToggleBtn.classList.remove("rotate"), 600);
    try {
        localStorage.setItem('hill_sagar_theme', isDark ? 'dark' : 'light');
    } catch (e) {}
});

applySavedTheme();

// Avatar style radio → hidden input + live preview big avatar
const avatarStyleInput = document.getElementById('avatarStyleInput');
const avatarRadios = document.querySelectorAll('input[name="avatar_style_choice"]');
const bigAvatar = document.getElementById('displayPhoto');

avatarRadios.forEach(radio => {
    radio.addEventListener('change', () => {
        const val = radio.value;
        avatarStyleInput.value = val;

        bigAvatar.classList.remove('avatar-circle', 'avatar-gold-ring');
        if (val === 'gold-ring') {
            bigAvatar.classList.add('avatar-gold-ring');
        } else {
            bigAvatar.classList.add('avatar-circle');
        }
    });
});

// LIVE PROFILE UPDATE — AJAX + popup
document.getElementById("profileForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    let r = await fetch("", {
        method: "POST",
        body: formData
    });

    let data;
    try {
        data = await r.json();
    } catch (err) {
        alert("Something went wrong, please try again.");
        return;
    }

    let msg = document.getElementById("updateMsg");

    if (data.success) {
        msg.style.color = "green";
        msg.textContent = data.message || "Profile updated successfully ✅";

        document.getElementById("displayName").textContent  = data.name;
        document.getElementById("displayEmail").textContent = data.email;
        document.getElementById("displayPhone").textContent = data.phone;

        if (data.photo) {
            const newSrc = "uploads/" + data.photo;
            document.getElementById("displayPhoto").src = newSrc;
            document.querySelectorAll('.avatar-preview').forEach(pre => {
                pre.style.backgroundImage = `url('${newSrc}')`;
            });
        }

        // Update big avatar class from server response
        if (data.avatar_style) {
            avatarStyleInput.value = data.avatar_style;
            bigAvatar.classList.remove('avatar-circle', 'avatar-gold-ring');
            if (data.avatar_style === 'gold-ring') {
                bigAvatar.classList.add('avatar-gold-ring');
            } else {
                bigAvatar.classList.add('avatar-circle');
            }

            // Sync radios
            avatarRadios.forEach(r => {
                r.checked = (r.value === data.avatar_style);
            });
        }

        // 🔔 Profile success popup
        showAlert(data.message || "Profile updated successfully ✅");
    } else {
        msg.style.color = "red";
        msg.textContent = data.message || "Update failed";
        showAlert(data.message || "Update failed ❌");
    }
});
</script>

</body>
</html>
