<?php
// Disable error reporting to prevent HTML warnings from breaking the JSON
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once 'config/config.php';
session_start();

$response = ['success' => false, 'message' => 'Unknown server error.'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Sanitize inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $full_name  = $first_name . " " . $last_name;
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $apt_date   = mysqli_real_escape_string($conn, $_POST['appt_date']);
    $apt_time   = mysqli_real_escape_string($conn, $_POST['appt_time']);
    $notes      = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
    
    // Handle optional Stylist
    $stylist_id = !empty($_POST['stylist_id']) ? "'" . mysqli_real_escape_string($conn, $_POST['stylist_id']) . "'" : "NULL";

    // 1. Check if client exists, otherwise create a temporary user record
    // This is required because 'client_id' is a NOT NULL foreign key
    if (isset($_SESSION['user_id'])) {
        $client_id = $_SESSION['user_id'];
    } else {
        $check_user = mysqli_query($conn, "SELECT id FROM users WHERE phone = '$phone' LIMIT 1");
        if (mysqli_num_rows($check_user) > 0) {
            $user_data = mysqli_fetch_assoc($check_user);
            $client_id = $user_data['id'];
        } else {
            // Create a record for the new client
            $dummy_pass = password_hash('guest123', PASSWORD_DEFAULT);
            $create_user = "INSERT INTO users (name, email, phone, password, role) 
                            VALUES ('$full_name', '$email', '$phone', '$dummy_pass', 'client')";
            if (mysqli_query($conn, $create_user)) {
                $client_id = mysqli_insert_id($conn);
            } else {
                throw new Exception('Could not register client info: ' . mysqli_error($conn));
            }
        }
    }

    // 2. Insert into appointments table
    $sql = "INSERT INTO appointments (client_id, stylist_id, service_id, apt_date, apt_time, status, notes) 
            VALUES ('$client_id', $stylist_id, '$service_id', '$apt_date', '$apt_time', 'pending', '$notes')";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = 'Success';
    } else {
        throw new Exception('Database error: ' . mysqli_error($conn));
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;