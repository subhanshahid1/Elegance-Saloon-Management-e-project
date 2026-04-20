<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'includes/db.php';
require_once 'includes/auth.php'; 

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

    // GLOBAL CAPACITY CHECK (The Fix)
    
    // 1. Get total count of active stylists currently in the system
    $s_res = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'stylist' AND status = 'active'");
    $total_stylists = $s_res->fetch_assoc()['total'];

    // 2. Get total number of bookings for this specific slot (regardless of stylist assigned)
    $a_res = $conn->prepare("SELECT COUNT(*) as booked FROM appointments WHERE apt_date = ? AND apt_time = ? AND status != 'cancelled'");
    $a_res->bind_param("ss", $apt_date, $apt_time);
    $a_res->execute();
    $total_booked = $a_res->get_result()->fetch_assoc()['booked'];

    // 3. Check if the salon is physically full
    if ($total_booked >= $total_stylists) {
        throw new Exception('I am sorry, all our stylists are fully booked for this time slot.');
    }

    // SPECIFIC STYLIST CHECK
    if ($stylist_id) {
        // Even if the salon isn't full, check if the specific person requested is busy
        $check = $conn->prepare("SELECT id FROM appointments WHERE apt_date = ? AND apt_time = ? AND stylist_id = ? AND status != 'cancelled'");
        $check->bind_param("ssi", $apt_date, $apt_time, $stylist_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            throw new Exception('The selected specialist is already booked for this time. Please choose another or select "No Preference".');
        }
    }

    // INSERT RECORD
    $stmt = $conn->prepare("INSERT INTO appointments (client_id, stylist_id, service_id, apt_date, apt_time, status, notes) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $stmt->bind_param("iiisss", $client_id, $stylist_id, $service_id, $apt_date, $apt_time, $notes);
    
    if ($stmt->execute()) {
        $formatted_time = date('h:i A', strtotime($apt_time));
        
        // Notifications
        notifyUser($conn, 1, "New Booking Request", "New booking from client ID #$client_id for $apt_date at $formatted_time.", "appointment", "appointments.php");
        if ($stylist_id) {
            notifyUser($conn, $stylist_id, "New Appointment", "New appointment for $apt_date at $formatted_time.", "appointment", "appointments.php");
        }
        notifyUser($conn, $client_id, "Booking Received", "Request for $apt_date at $formatted_time is pending.", "appointment", "index.php");
        
        $response = ['success' => true, 'message' => 'Appointment booked successfully!'];
    } else {
        throw new Exception('Database error: Unable to save booking.');
    }

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);