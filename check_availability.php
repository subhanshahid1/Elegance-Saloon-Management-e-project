<?php
require_once 'includes/db.php';
$date = $_GET['date'] ?? '';
$stylist_id = $_GET['stylist_id'] ?? '';
$booked = [];

if(!empty($date)) {
    if(!empty($stylist_id)) {
        // Check specific stylist
        $query = "SELECT apt_time FROM appointments WHERE apt_date = '$date' AND stylist_id = '$stylist_id' AND status != 'cancelled'";
    } else {
        // If "Any" is picked, we only hide the slot if ALL stylists are busy.
        // Assuming you have 3 stylists total. Change '3' to your actual count.
        $query = "SELECT apt_time FROM appointments WHERE apt_date = '$date' AND status != 'cancelled' GROUP BY apt_time HAVING count(*) >= 3";
    }
    
    $res = $conn->query($query);
    while($row = $res->fetch_assoc()) {
        $booked[] = $row['apt_time'];
    }
}
echo json_encode(['booked' => $booked]);