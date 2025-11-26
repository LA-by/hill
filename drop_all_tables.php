<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'tours_travels');
    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }

    $result = $mysqli->query("SHOW TABLES");
    if (!$result) {
        throw new Exception('Error fetching tables: ' . $mysqli->error);
    }

    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    foreach ($tables as $table) {
        $mysqli->query("DROP TABLE `$table`");
        if ($mysqli->error) {
            throw new Exception('Error dropping table ' . $table . ': ' . $mysqli->error);
        }
    }

    echo "All tables dropped.";
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
