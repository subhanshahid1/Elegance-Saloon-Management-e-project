<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. ADD STAFF
if (isset($_POST['add_staff'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $_POST['role'];
    $commission = (float)$_POST['commission_rate'];
    $schedule = $conn->real_escape_string($_POST['work_schedule']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // CHECK IF EMAIL EXISTS
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $res = $checkEmail->get_result();

    if ($res->num_rows > 0) {
        header("Location: staff.php?msg=email_exists");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, role, commission_rate, work_schedule, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("ssssdss", $name, $email, $phone, $role, $commission, $schedule, $password);
    
    if($stmt->execute()) {
        header("Location: staff.php?msg=added");
    } else {
        header("Location: staff.php?msg=error");
    }
    exit();
}

// 2. UPDATE STAFF
if (isset($_POST['update_staff'])) {
    $id = (int)$_POST['staff_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $status = $_POST['status'];
    $commission = (float)$_POST['commission_rate'];
    $schedule = $conn->real_escape_string($_POST['work_schedule']);

    // Check if email belongs to someone else
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $checkEmail->bind_param("si", $email, $id);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        header("Location: staff.php?msg=email_exists");
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, status=?, commission_rate=?, work_schedule=? WHERE id=?");
    $stmt->bind_param("ssssdsi", $name, $email, $phone, $status, $commission, $schedule, $id);
    
    if (!empty($_POST['password'])) {
        $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$new_pass' WHERE id=$id");
    }

    $stmt->execute();
    header("Location: staff.php?msg=updated");
    exit();
}

// 3. DELETE STAFF
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    if ($id != $_SESSION['user_id']) {
        $conn->query("DELETE FROM users WHERE id = $id");
        header("Location: staff.php?msg=deleted");
    } else {
        header("Location: staff.php?msg=error_self_delete");
    }
    exit();
}