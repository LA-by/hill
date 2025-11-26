<?php
require_once __DIR__ . '/includes/db.php';

if (!isset($_GET['id'])) exit("Invalid Request");

$id = (int)$_GET['id'];

$q = $mysqli->prepare("SELECT * FROM bookings WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$data = $q->get_result()->fetch_assoc();

if (!$data) exit("Booking Not Found");

echo "<h2>✅ Booking Verified</h2>";
echo "Booking ID: HS-$id<br>";
echo "Name: {$data['full_name']}<br>";
echo "Destination: {$data['destination']}<br>";
echo "Status: {$data['status']}<br>";
?>
