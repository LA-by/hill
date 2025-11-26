<?php
require_once __DIR__ . '/includes/db.php';

// New admin credentials
$username = 'admin';
$password = 'admin';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Updating admin credentials:\n";
echo "========================\n";
echo "Username: $username\n";
echo "Password: $password\n";
echo "Hash: $hash\n\n";

global $mysqli;

// Check if admin exists
$stmt = $mysqli->prepare('SELECT id FROM admins WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();
$stmt->close();

if ($existing) {
    // Update existing admin
    $stmt = $mysqli->prepare('UPDATE admins SET password_hash = ? WHERE username = ?');
    $stmt->bind_param('ss', $hash, $username);
    $stmt->execute();
    $stmt->close();
    echo "Admin credentials updated successfully.\n";
} else {
    // Insert new admin
    $stmt = $mysqli->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
    $stmt->bind_param('ss', $username, $hash);
    $stmt->execute();
    $stmt->close();
    echo "New admin created successfully.\n";
}

echo "SQL executed:\n";
echo "UPDATE admins SET password_hash = '$hash' WHERE username = '$username';\n";
?>
