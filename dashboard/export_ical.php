<?php
require_once '../includes/db.php';

$token = $_GET['token'] ?? '';
$uid = $_GET['uid'] ?? 0;

// Security Check: Verify token matches the UID provided
if ($token !== md5($uid . 'salon_salt')) {
    die("Unauthorized access.");
}

// Get User Role to determine filtering
$user_check = $conn->query("SELECT role FROM users WHERE id = ".intval($uid));
$user_data = $user_check->fetch_assoc();
$role = $user_data['role'] ?? 'client';

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="salon_schedule.ics"');

echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//Elegance Salon//Scheduling System//EN\n";
echo "CALSCALE:GREGORIAN\n";
echo "METHOD:PUBLISH\n";

// Query based on role
$sql = "SELECT a.*, u.name as client, s.name as service 
        FROM appointments a 
        JOIN users u ON a.client_id = u.id 
        JOIN services s ON a.service_id = s.id 
        WHERE a.status = 'confirmed'";

if ($role === 'stylist') {
    $sql .= " AND a.stylist_id = " . intval($uid);
}

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $dt_start = date('Ymd\THis', strtotime($row['apt_date'] . ' ' . $row['apt_time']));
    // Assume 1 hour duration
    $dt_end = date('Ymd\THis', strtotime($row['apt_date'] . ' ' . $row['apt_time'] . ' +1 hour'));
    $created = date('Ymd\THis', strtotime($row['created_at']));

    echo "BEGIN:VEVENT\n";
    echo "UID:" . $row['id'] . "@elegancesalon.com\n";
    echo "DTSTAMP:" . $created . "Z\n";
    echo "DTSTART:$dt_start\n";
    echo "DTEND:$dt_end\n";
    echo "SUMMARY:Salon: " . $row['client'] . " - " . $row['service'] . "\n";
    echo "DESCRIPTION:Appointment Status: " . $row['status'] . "\\nNotes: " . $row['notes'] . "\n";
    echo "END:VEVENT\n";
}

echo "END:VCALENDAR";