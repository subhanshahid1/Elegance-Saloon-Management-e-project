<?php
require_once '../includes/db.php';

// Simple security check via token (e.g., export_ical.php?token=xyz)
$token = $_GET['token'] ?? '';
// In a real app, verify the token against a user ID in the database

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="salon_schedule.ics"');

echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//Elegance Salon//Scheduling System//EN\n";

$sql = "SELECT a.*, u.name as client, s.name as service 
        FROM appointments a 
        JOIN users u ON a.client_id = u.id 
        JOIN services s ON a.service_id = s.id 
        WHERE a.status = 'confirmed'";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $start = date('Ymd\THis', strtotime($row['apt_date'] . ' ' . $row['apt_time']));
    $end = date('Ymd\THis', strtotime($row['apt_date'] . ' ' . $row['apt_time'] . ' +1 hour'));
    
    echo "BEGIN:VEVENT\n";
    echo "SUMMARY:" . $row['client'] . " - " . $row['service'] . "\n";
    echo "DTSTART:$start\n";
    echo "DTEND:$end\n";
    echo "DESCRIPTION:Salon Appointment\n";
    echo "END:VEVENT\n";
}

echo "END:VCALENDAR";