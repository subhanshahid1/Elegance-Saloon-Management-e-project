<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (getUserRole() !== 'admin') {
    header("Location: clients.php?msg=unauthorized");
    exit();
}

if (isset($_POST['save_client'])) {
    $id      = (int)$_POST['c_id'];
    $name    = $conn->real_escape_string($_POST['c_name']);
    $phone   = $conn->real_escape_string($_POST['c_phone']);
    $email   = $conn->real_escape_string($_POST['c_email']);
    $dob     = !empty($_POST['c_dob']) ? "'" . $conn->real_escape_string($_POST['c_dob']) . "'" : "NULL";
    $stylist = !empty($_POST['c_stylist']) ? (int)$_POST['c_stylist'] : "NULL";
    $prefs   = $conn->real_escape_string($_POST['c_prefs']);

    if ($id > 0) {
        // Update existing
        $sql = "UPDATE users SET name='$name', phone='$phone', email='$email', dob=$dob, preferred_stylist_id=$stylist, preferences='$prefs' WHERE id=$id";
    } else {
        // Add new
        $pass = password_hash("client123", PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone, password, role, dob, preferred_stylist_id, preferences, status) 
                VALUES ('$name', '$email', '$phone', '$pass', 'client', $dob, $stylist, '$prefs', 'active')";
    }

    $conn->query($sql);
    header("Location: clients.php?msg=success");
    exit();
}

if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $conn->query("DELETE FROM users WHERE id=$id AND role='client'");
    header("Location: clients.php?msg=deleted");
    exit();
}
