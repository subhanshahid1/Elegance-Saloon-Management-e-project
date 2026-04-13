<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

$uid = getUserId();
$target = $_GET['redirect'] ?? 'index.php';

if ($uid) {
    // This marks them as read so the bubble count drops
    $conn->query("UPDATE notifications SET is_read = 1 WHERE user_id = $uid");
}

header("Location: " . $target);
exit;