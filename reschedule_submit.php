<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apt_id = intval($_POST['apt_id']);
    $date = $_POST['appt_date'];
    $time = $_POST['appt_time'];
    $stylist_id = !empty($_POST['stylist_id']) ? intval($_POST['stylist_id']) : null;

    // Server-side safety check
    if ($stylist_id) {
        $q = "SELECT id FROM appointments WHERE apt_date='$date' AND apt_time='$time' AND stylist_id='$stylist_id' AND id != $apt_id AND status != 'cancelled'";
    } else {
        $s_res = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'stylist' AND status = 'active'");
        $total = $s_res->fetch_assoc()['total'];
        $q = "SELECT id FROM appointments WHERE apt_date='$date' AND apt_time='$time' AND id != $apt_id AND status != 'cancelled' HAVING COUNT(*) >= $total";
    }

    $check = $conn->query($q);
    if($check && $check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'This slot is no longer available.']);
        exit;
    }

    $sql = "UPDATE appointments SET apt_date='$date', apt_time='$time', stylist_id=" . ($stylist_id ?? 'NULL') . ", status='pending' WHERE id=$apt_id";
    if($conn->query($sql)) { 
        echo json_encode(['success' => true]); 
    } else { 
        echo json_encode(['success' => false, 'message' => 'Update failed.']); 
    }
}