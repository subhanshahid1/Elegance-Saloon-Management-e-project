<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// 1. ADD SUPPLIER
if (isset($_POST['add_supplier'])) {
    $name    = $conn->real_escape_string($_POST['s_name']);
    $contact = $conn->real_escape_string($_POST['s_contact']);
    $phone   = $conn->real_escape_string($_POST['s_phone']);
    $email   = $conn->real_escape_string($_POST['s_email']);
    $addr    = $conn->real_escape_string($_POST['s_address']);

    $conn->query("INSERT INTO suppliers (supplier_name, contact_person, email, phone, address) 
                  VALUES ('$name', '$contact', '$email', '$phone', '$addr')");
    
    header("Location: suppliers.php?msg=added");
    exit();
}

// 2. UPDATE SUPPLIER
if (isset($_POST['update_supplier'])) {
    $id      = (int)$_POST['s_id'];
    $name    = $conn->real_escape_string($_POST['s_name']);
    $contact = $conn->real_escape_string($_POST['s_contact']);
    $phone   = $conn->real_escape_string($_POST['s_phone']);
    $email   = $conn->real_escape_string($_POST['s_email']);
    $addr    = $conn->real_escape_string($_POST['s_address']);

    $conn->query("UPDATE suppliers SET 
                  supplier_name='$name', contact_person='$contact', 
                  email='$email', phone='$phone', address='$addr' 
                  WHERE id=$id");
    
    header("Location: suppliers.php?msg=updated");
    exit();
}

// 3. DELETE SUPPLIER
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $conn->query("DELETE FROM suppliers WHERE id=$id");
    header("Location: suppliers.php?msg=deleted");
    exit();
}