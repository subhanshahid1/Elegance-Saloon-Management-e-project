<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);
$current_role = getUserRole();

if (isset($_POST['add_staff'])) {
    if($current_role !== 'admin') { header("Location: staff.php?err=unauthorized"); exit(); }
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $comm = (float)$_POST['commission_rate'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sched = $conn->real_escape_string($_POST['work_schedule']);

    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if($check->num_rows > 0) { header("Location: staff.php?msg=email_exists"); exit(); }

    $sql = "INSERT INTO users (name, email, password, role, commission_rate, work_schedule, status) 
            VALUES ('$name', '$email', '$pass', '$role', $comm, '$sched', 'active')";
    if($conn->query($sql)) { header("Location: staff.php?msg=added"); }
    exit();
}

if (isset($_POST['update_staff'])) {
    $id = (int)$_POST['staff_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $sched = $conn->real_escape_string($_POST['work_schedule']);
    $query = "UPDATE users SET name='$name', email='$email', work_schedule='$sched'";

    if ($current_role === 'admin') {
        if(isset($_POST['commission_rate'])) {
            $comm = (float)$_POST['commission_rate'];
            $query .= ", commission_rate=$comm";
        }
        if(!empty($_POST['password'])) {
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query .= ", password='$pass'";
        }
    }
    $query .= " WHERE id=$id";
    if($conn->query($query)) { header("Location: staff.php?msg=updated"); }
    exit();
}

if (isset($_GET['delete_id']) && $current_role === 'admin') {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: staff.php?msg=deleted");
    exit();
}