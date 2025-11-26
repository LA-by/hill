<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tours_travels', 'root', '');
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo 'Tables: ' . implode(', ', $tables);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
