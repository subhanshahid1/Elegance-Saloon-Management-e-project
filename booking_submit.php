<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'includes/db.php';

$response = ['success' => false, 'message' => 'Unknown error'];

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Access denied. Please login.');
    }

    $client_id  = $_SESSION['user_id'];
    $service_id = $_POST['service_id'] ?? null;
    $stylist_id = !empty($_POST['stylist_id']) ? intval($_POST['stylist_id']) : null;
    $apt_date   = $_POST['appt_date'] ?? ''; 
    $apt_time   = $_POST['appt_time'] ?? ''; 
    $notes      = $_POST['notes'] ?? '';

    if (empty($service_id) || empty($apt_date) || empty($apt_time)) {
        throw new Exception('Please select a service, date, and time.');
    }

    // Double-check availability (Security requirement)
    $check = $conn->prepare("SELECT id FROM appointments WHERE apt_date = ? AND apt_time = ? AND status != 'cancelled'");
    $check->bind_param("ss", $apt_date, $apt_time);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        throw new Exception('Sorry, this slot was just taken. Please pick another time.');
    }

    $stmt = $conn->prepare("INSERT INTO appointments (client_id, stylist_id, service_id, apt_date, apt_time, status, notes) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $stmt->bind_param("iiisss", $client_id, $stylist_id, $service_id, $apt_date, $apt_time, $notes);
    
    if ($stmt->execute()) {
        // REQ: Automated confirmation notification
        // In production, use: mail($_SESSION['user_email'], "Booking Received", "We have received your request...");
        
        $response = ['success' => true, 'message' => 'Appointment booked successfully!'];
    } else {
        throw new Exception('Database error: ' . $conn->error);
    }

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
exit;