<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
checkAccess(['admin']);

// 1. ADD NEW SERVICE
if (isset($_POST['add_service'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO services (name, description, price, duration, status) 
            VALUES ('$name', '$desc', '$price', '$duration', 'active')";
    
    if ($conn->query($sql)) {
        header("Location: services.php?msg=added");
        exit();
    }
}

// 2. UPDATE EXISTING SERVICE
if (isset($_POST['update_service'])) {
    $id = (int)$_POST['service_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE services SET 
            name = '$name', 
            description = '$desc', 
            price = '$price', 
            duration = '$duration', 
            status = '$status' 
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: services.php?msg=updated");
        exit();
    }
}

// 3. DELETE SERVICE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM services WHERE id = $id");
    header("Location: services.php?msg=deleted");
    exit();
}