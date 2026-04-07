<?php
// ===== DATABASE CONNECTION =====

// Use __DIR__ to ensure it finds the file relative to THIS folder (includes/)
// We go up one level (..) then into config/
require_once __DIR__ . '/../config/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for special characters
$conn->set_charset("utf8mb4");
?>