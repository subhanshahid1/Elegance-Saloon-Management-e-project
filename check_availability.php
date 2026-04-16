<?php
require_once 'includes/db.php';

$date = $_GET['date'] ?? '';
$stylist_id = $_GET['stylist_id'] ?? '';
$exclude_id = isset($_GET['exclude_id']) ? intval($_GET['exclude_id']) : 0;
$booked = [];

if(!empty($date)) {
    // 1. Get total count of active stylists currently in the system
    $stylist_count_res = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'stylist' AND status = 'active'");
    $total_stylists = $stylist_count_res->fetch_assoc()['total'];

    // 2. Get the count of "No Preference" bookings (where stylist_id is NULL)
    $no_pref_query = "SELECT apt_time, COUNT(*) as count FROM appointments 
                      WHERE apt_date = '$date' AND stylist_id IS NULL 
                      AND status != 'cancelled' AND id != $exclude_id 
                      GROUP BY apt_time";
    $no_pref_res = $conn->query($no_pref_query);
    $no_pref_counts = [];
    while($row = $no_pref_res->fetch_assoc()) {
        $no_pref_counts[$row['apt_time']] = $row['count'];
    }

    // 3. Get total bookings (Specific + No Preference) per slot
    $total_booked_query = "SELECT apt_time, COUNT(*) as total_booked FROM appointments 
                           WHERE apt_date = '$date' AND status != 'cancelled' 
                           AND id != $exclude_id GROUP BY apt_time";
    $total_res = $conn->query($total_booked_query);
    $total_booked_counts = [];
    while($row = $total_res->fetch_assoc()) {
        $total_booked_counts[$row['apt_time']] = $row['total_booked'];
    }

    // 4. Logic to determine if a slot is "Taken"
    // We check all potential slots (your $slots array logic from the frontend)
    $slots = ["10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00"];
    
    foreach($slots as $s) {
        $is_full = ($total_booked_counts[$s] ?? 0) >= $total_stylists;
        
        if (!empty($stylist_id)) {
            // Check if THIS specific stylist is already booked
            $spec_check = $conn->query("SELECT id FROM appointments WHERE apt_date='$date' AND apt_time='$s' AND stylist_id='$stylist_id' AND status != 'cancelled' AND id != $exclude_id");
            
            // Slot is taken if the specific stylist is busy OR if the whole shop is full
            if($spec_check->num_rows > 0 || $is_full) {
                $booked[] = $s;
            }
        } else {
            // No preference selected: Slot is taken only if shop is full
            if($is_full) {
                $booked[] = $s;
            }
        }
    }
}
echo json_encode(['booked' => $booked]);