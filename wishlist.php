<?php
require_once __DIR__.'/includes/session.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/auth.php';
requireUserLogin();

header("Content-Type: application/json");

$userId    = (int) $_SESSION['user_id'];
$bookingId = (int) ($_POST['booking_id'] ?? 0);
$action    = $_POST['action'] ?? '';

if (!$bookingId) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

if ($action === "add") {
    $stmt = $mysqli->prepare("INSERT IGNORE INTO wishlist (user_id, booking_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $bookingId);
    $stmt->execute();
    $stmt->close();
    echo json_encode(["success" => true, "status" => "added"]);
    exit;
}

if ($action === "remove") {
    $stmt = $mysqli->prepare("DELETE FROM wishlist WHERE user_id=? AND booking_id=?");
    $stmt->bind_param("ii", $userId, $bookingId);
    $stmt->execute();
    $stmt->close();
    echo json_encode(["success" => true, "status" => "removed"]);
    exit;
}

echo json_encode(["success" => false, "message" => "Unknown action"]);
