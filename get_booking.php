<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
requireUserLogin();

$userId    = (int)$_SESSION['user_id'];
$bookingId = (int)($_GET['id'] ?? 0);

header('Content-Type: application/json');

$stmt = $mysqli->prepare("
    SELECT id, destination, state, package_type, travel_start_date, travel_end_date,
           travelers, hotel_type, transport, special_requests, status, created_at
    FROM bookings
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $bookingId, $userId);
$stmt->execute();
$res  = $stmt->get_result();
$data = $res->fetch_assoc();
$stmt->close();

if ($data) {
    echo json_encode(['success' => true, 'booking' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
}
