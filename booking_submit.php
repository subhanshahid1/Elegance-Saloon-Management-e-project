<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'includes/db.php';
require_once 'includes/auth.php'; // Required to use notifyUser()

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

    // Double-check availability
    $check = $conn->prepare("SELECT id FROM appointments WHERE apt_date = ? AND apt_time = ? AND status != 'cancelled'");
    $check->bind_param("ss", $apt_date, $apt_time);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        throw new Exception('Sorry, this slot was just taken. Please pick another time.');
    }

    $stmt = $conn->prepare("INSERT INTO appointments (client_id, stylist_id, service_id, apt_date, apt_time, status, notes) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    $stmt->bind_param("iiisss", $client_id, $stylist_id, $service_id, $apt_date, $apt_time, $notes);
    
    if ($stmt->execute()) {
        
        // --- NOTIFICATION LOGIC START ---
        $formatted_time = date('h:i A', strtotime($apt_time));
        
        // 1. Notify Admin (Assuming Admin User ID is 1)
        $admin_msg = "New booking from client ID #$client_id for $apt_date at $formatted_time.";
        notifyUser($conn, 1, "New Booking Request", $admin_msg, "appointment", "appointments.php");

        // 2. Notify the Stylist (if assigned)
        if ($stylist_id) {
            $stylist_msg = "You have a new appointment assigned for $apt_date at $formatted_time.";
            notifyUser($conn, $stylist_id, "New Appointment", $stylist_msg, "appointment", "appointments.php");
        }

        // 3. Notify the Client (Self)
        notifyUser($conn, $client_id, "Booking Received", "Your request for $apt_date at $formatted_time is pending approval.", "appointment", "index.php");
        // --- NOTIFICATION LOGIC END ---
        
        $response = ['success' => true, 'message' => 'Appointment booked successfully!'];
    } else {
        throw new Exception('Database error: ' . $conn->error);
    }

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
exit;