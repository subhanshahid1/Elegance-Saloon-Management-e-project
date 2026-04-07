<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. ADD CLIENT
if (isset($_POST['add_client'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'client';

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $password, $role);
    
    if($stmt->execute()){
        header("Location: clients.php?msg=added");
    } else {
        header("Location: clients.php?msg=error");
    }
    exit();
}

// 2. UPDATE CLIENT
if (isset($_POST['update_client'])) {
    $id = (int)$_POST['client_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $new_password = $_POST['password'];

    if (!empty($new_password)) {
        $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, password=? WHERE id=? AND role='client'");
        $stmt->bind_param("ssssi", $name, $email, $phone, $hashed_pass, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=? WHERE id=? AND role='client'");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
    }
    
    $stmt->execute();
    header("Location: clients.php?msg=updated");
    exit();
}

// 3. DELETE CLIENT
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $id AND role = 'client'");
    header("Location: clients.php?msg=deleted");
    exit();
}