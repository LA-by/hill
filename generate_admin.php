<?php
// Generate admin password hash
$password = 'Admin@123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Admin Setup Instructions:\n";
echo "========================\n";
echo "Username: admin\n";
echo "Password: $password\n";
echo "Hash: $hash\n\n";

echo "SQL to run in phpMyAdmin:\n";
echo "INSERT INTO admins (username, password_hash) VALUES ('admin', '$hash');\n";
?>
