<?php
// Prevent any PHP warnings or errors from breaking the JSON output
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once 'includes/db.php'; // Uses your DB_HOST, DB_USER, etc.

$response = ['success' => false, 'message' => 'Unknown error'];

try {
    // 1. Mandatory Login Check
    // Now that you require login, we pull the client_id directly from the session
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Access denied. Please login to book an appointment.');
    }

    $client_id  = $_SESSION['user_id'];
    $service_id = $_POST['service_id'] ?? null;
    $stylist_id = !empty($_POST['stylist_id']) ? intval($_POST['stylist_id']) : null;
    $apt_date   = $_POST['appt_date'] ?? ''; // Column name from saloon.sql
    $apt_time   = $_POST['appt_time'] ?? ''; // Column name from saloon.sql
    $notes      = $_POST['notes'] ?? '';

    // 2. Validation
    if (empty($service_id) || empty($apt_date) || empty($apt_time)) {
        throw new Exception('Please select a service, date, and time.');
    }

    // 3. Insert into appointments table
    // We use prepared statements to prevent SQL injection and "Unexpected token" crashes
    $stmt = $conn->prepare("INSERT INTO appointments (client_id, stylist_id, service_id, apt_date, apt_time, status, notes) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
    
    // "iiisss" means: integer, integer, integer, string, string, string
    $stmt->bind_param("iiisss", $client_id, $stylist_id, $service_id, $apt_date, $apt_time, $notes);
    
    if ($stmt->execute()) {
        $response = [
            'success' => true, 
            'message' => 'Appointment booked successfully!'
        ];
    } else {
        throw new Exception('Database error: ' . $conn->error);
    }

} catch (Exception $e) {
    $response = [
        'success' => false, 
        'message' => $e->getMessage()
    ];
}

// Ensure ONLY the JSON is echoed
echo json_encode($response);
exit;