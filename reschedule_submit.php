<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apt_id = intval($_POST['apt_id']);
    $date = $_POST['appt_date'];
    $time = $_POST['appt_time'];
    $stylist = $_POST['stylist_id'];

    // Check availability one last time (excluding the current record)
    $q = "SELECT id FROM appointments WHERE apt_date='$date' AND apt_time='$time' AND stylist_id='$stylist' AND id != $apt_id AND status != 'cancelled'";
    $check = $conn->query($q);
    
    if($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'This slot is now taken by another client.']);
        exit;
    }

    $sql = "UPDATE appointments SET apt_date='$date', apt_time='$time', stylist_id='$stylist', status='pending' WHERE id=$apt_id";
    if($conn->query($sql)) { echo json_encode(['success' => true]); } 
    else { echo json_encode(['success' => false, 'message' => 'Update failed.']); }
}