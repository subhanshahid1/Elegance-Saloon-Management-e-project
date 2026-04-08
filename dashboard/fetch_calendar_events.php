<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$uid = getUserId();
$role = getUserRole();
$events = [];

// 1. Fetch Appointments
$sql = "SELECT a.*, u.name as client, s.name as service 
        FROM appointments a 
        JOIN users u ON a.client_id = u.id 
        JOIN services s ON a.service_id = s.id";

if ($role === 'stylist') {
    $sql .= " WHERE a.stylist_id = $uid";
}

$res = $conn->query($sql);
while($row = $res->fetch_assoc()) {
    $events[] = [
        'title' => $row['client'] . ' - ' . $row['service'],
        'start' => $row['apt_date'] . 'T' . $row['apt_time'],
        'description' => 'Client: ' . $row['client'],
        'status' => $row['status'],
        'type' => 'appointment'
    ];
}

// 2. Fetch Staff Shifts
$shift_sql = ($role === 'stylist') ? "SELECT * FROM staff_shifts WHERE staff_id = $uid" : "SELECT s.*, u.name as staff_name FROM staff_shifts s JOIN users u ON s.staff_id = u.id";
$s_res = $conn->query($shift_sql);
while($row = $s_res->fetch_assoc()) {
    $name = isset($row['staff_name']) ? $row['staff_name'] . ' Shift' : 'My Shift';
    $events[] = [
        'title' => $name,
        'start' => $row['shift_date'] . 'T' . $row['start_time'],
        'end' => $row['shift_date'] . 'T' . $row['end_time'],
        'type' => 'shift',
        'allDay' => false
    ];
}

echo json_encode($events);