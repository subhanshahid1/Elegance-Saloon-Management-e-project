<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$uid = getUserId();
$role = getUserRole();
$events = [];

// 1. Fetch Appointments (Joining users and services based on DB schema)
if ($role === 'stylist') {
    $stmt = $conn->prepare("SELECT a.*, u.name as client, s.name as service 
                            FROM appointments a 
                            JOIN users u ON a.client_id = u.id 
                            JOIN services s ON a.service_id = s.id 
                            WHERE a.stylist_id = ?");
    $stmt->bind_param("i", $uid);
} else {
    // Admin/Receptionist sees everything
    $stmt = $conn->prepare("SELECT a.*, u.name as client, s.name as service 
                            FROM appointments a 
                            JOIN users u ON a.client_id = u.id 
                            JOIN services s ON a.service_id = s.id");
}

$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $events[] = [
        'title' => $row['client'] . ' - ' . $row['service'],
        'start' => $row['apt_date'] . 'T' . $row['apt_time'],
        'status' => $row['status'],
        'type' => 'appointment'
    ];
}

// 2. Fetch Staff Shifts
if ($role === 'stylist') {
    $stmt2 = $conn->prepare("SELECT * FROM staff_shifts WHERE staff_id = ?");
    $stmt2->bind_param("i", $uid);
} else {
    $stmt2 = $conn->prepare("SELECT s.*, u.name as staff_name FROM staff_shifts s JOIN users u ON s.staff_id = u.id");
}

$stmt2->execute();
$s_res = $stmt2->get_result();
while ($row = $s_res->fetch_assoc()) {
    $events[] = [
        'title' => (isset($row['staff_name']) ? $row['staff_name'] : 'My') . ' Shift',
        'start' => $row['shift_date'] . 'T' . $row['start_time'],
        'end' => $row['shift_date'] . 'T' . $row['end_time'],
        'type' => 'shift'
    ];
}

echo json_encode($events);
