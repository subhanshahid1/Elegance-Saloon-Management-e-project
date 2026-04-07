<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. ADD STAFF
if (isset($_POST['add_staff'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);
    $comm = (float)$_POST['commission_rate'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sched = $conn->real_escape_string($_POST['work_schedule']);

    // Check if email exists
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if($check->num_rows > 0) {
        header("Location: staff.php?msg=email_exists");
        exit();
    }

    $sql = "INSERT INTO users (name, email, password, role, phone, commission_rate, work_schedule, status) 
            VALUES ('$name', '$email', '$pass', '$role', '$phone', $comm, '$sched', 'active')";
    
    if($conn->query($sql)) {
        header("Location: staff.php?msg=added");
    }
    exit();
}

// 2. UPDATE STAFF
if (isset($_POST['update_staff'])) {
    $id = (int)$_POST['staff_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $status = $conn->real_escape_string($_POST['status']);
    $comm = (float)$_POST['commission_rate'];
    $sched = $conn->real_escape_string($_POST['work_schedule']);

    $query = "UPDATE users SET name='$name', email='$email', phone='$phone', status='$status', 
              commission_rate=$comm, work_schedule='$sched'";

    if(!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query .= ", password='$pass'";
    }

    $query .= " WHERE id=$id";
    
    if($conn->query($query)) {
        header("Location: staff.php?msg=updated");
    }
    exit();
}

// 3. DELETE STAFF
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: staff.php?msg=deleted");
    exit();
}