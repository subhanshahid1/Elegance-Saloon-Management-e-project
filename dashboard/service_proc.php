<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// 1. ADD
if (isset($_POST['btn_add'])) {
    $name = $conn->real_escape_string($_POST['add_name']);
    $cat  = !empty($_POST['add_category']) ? $conn->real_escape_string($_POST['add_category']) : 'General';
    $pr   = (float)$_POST['add_price'];
    $dur  = (int)$_POST['add_duration'];

    $sql = "INSERT INTO services (name, category, price, duration, status) VALUES ('$name', '$cat', $pr, $dur, 'active')";
    $conn->query($sql);
    header("Location: services.php?msg=added");
    exit();
}

// 2. UPDATE
if (isset($_POST['btn_update'])) {
    $id   = (int)$_POST['upd_id'];
    $name = $conn->real_escape_string($_POST['upd_name']);
    $cat  = !empty($_POST['upd_category']) ? $conn->real_escape_string($_POST['upd_category']) : 'General';
    $pr   = (float)$_POST['upd_price'];
    $dur  = (int)$_POST['upd_duration'];
    $st   = $conn->real_escape_string($_POST['upd_status']);

    $sql = "UPDATE services SET name='$name', category='$cat', price=$pr, duration=$dur, status='$st' WHERE id=$id";
    
    if($conn->query($sql)) {
        header("Location: services.php?msg=updated");
    } else {
        die("Error: " . $conn->error);
    }
    exit();
}

// 3. DELETE (Restored)
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $conn->query("DELETE FROM services WHERE id = $id");
    header("Location: services.php?msg=deleted");
    exit();
}