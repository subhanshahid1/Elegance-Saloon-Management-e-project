<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

header('Content-Type: application/json');
checkAccess(['admin', 'receptionist']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apt_id = intval($_POST['apt_id']);
    $stylist_id = intval($_POST['stylist_id']);

    $stmt = $conn->prepare("SELECT apt_date, apt_time FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $apt_id);
    $stmt->execute();
    $apt = $stmt->get_result()->fetch_assoc();

    // Conflict Check
    $check = $conn->prepare("SELECT id FROM appointments 
                            WHERE stylist_id = ? 
                            AND apt_date = ? 
                            AND apt_time = ? 
                            AND status != 'cancelled' 
                            AND id != ?");
    $check->bind_param("issi", $stylist_id, $apt['apt_date'], $apt['apt_time'], $apt_id);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Stylist already booked for this slot']);
        exit;
    }

    $update = $conn->prepare("UPDATE appointments SET stylist_id = ? WHERE id = ?");
    $update->bind_param("ii", $stylist_id, $apt_id);

    if ($update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
}