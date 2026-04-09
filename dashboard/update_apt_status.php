<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $current_uid = getUserId();
    $current_role = getUserRole();

    // Security check: Stylists can only update their own appointments
    if ($current_role === 'stylist') {
        $check = $conn->query("SELECT id FROM appointments WHERE id = $id AND stylist_id = $current_uid");
        if ($check->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Permission denied']);
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
}