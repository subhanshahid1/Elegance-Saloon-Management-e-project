<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

if (isset($_POST['btn_update_apt'])) {
    $id = $_POST['apt_id'];
    $stylist_id = !empty($_POST['stylist_id']) ? $_POST['stylist_id'] : "NULL";
    $status = $_POST['status'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $query = "UPDATE appointments SET 
              stylist_id = $stylist_id, 
              status = '$status', 
              notes = '$notes' 
              WHERE id = $id";

    if ($conn->query($query)) {
        header("Location: appointments.php?msg=updated");
    } else {
        header("Location: appointments.php?msg=error");
    }
}