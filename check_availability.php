<?php
require_once 'includes/db.php';

$date = $_GET['date'] ?? '';
$stylist_id = $_GET['stylist_id'] ?? '';
$exclude_id = isset($_GET['exclude_id']) ? intval($_GET['exclude_id']) : 0;
$booked = [];

if(!empty($date)) {
    // 1. Get total count of active stylists dynamically
    $stylist_count_res = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'stylist' AND status = 'active'");
    $total_available_stylists = $stylist_count_res->fetch_assoc()['total'];

    if(!empty($stylist_id)) {
        // If a specific stylist is picked, check ONLY their schedule
        $query = "SELECT apt_time FROM appointments 
                  WHERE apt_date = '$date' 
                  AND stylist_id = '$stylist_id' 
                  AND status != 'cancelled' 
                  AND id != $exclude_id";
    } else {
        // "No Preference": Hide slot only if ALL stylists are busy at this specific time
        $query = "SELECT apt_time FROM appointments 
                  WHERE apt_date = '$date' 
                  AND status != 'cancelled' 
                  AND id != $exclude_id 
                  GROUP BY apt_time 
                  HAVING COUNT(*) >= $total_available_stylists";
    }
    
    $res = $conn->query($query);
    while($row = $res->fetch_assoc()) {
        $booked[] = $row['apt_time'];
    }
}
echo json_encode(['booked' => $booked]);