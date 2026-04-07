<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// 1. ADD NEW PAYMENT
if (isset($_POST['process_payment'])) {
    $client_id = (int)$_POST['client_id'];
    $stylist_id = (int)$_POST['stylist_id'];
    $amount = (float)$_POST['amount'];
    $method = $_POST['method'];

    $stmt = $conn->prepare("INSERT INTO payments (client_id, amount, method, status) VALUES (?, ?, ?, 'paid')");
    $stmt->bind_param("ids", $client_id, $amount, $method);
    
    if ($stmt->execute()) {
        // Fetch Stylist Commission Rate
        $st_res = $conn->query("SELECT commission_rate FROM users WHERE id = $stylist_id");
        $stylist = $st_res->fetch_assoc();
        $comm_amount = ($stylist['commission_rate'] / 100) * $amount;

        // Record Commission
        $comm_stmt = $conn->prepare("INSERT INTO commissions (stylist_id, amount, status) VALUES (?, ?, 'pending')");
        $comm_stmt->bind_param("id", $stylist_id, $comm_amount);
        $comm_stmt->execute();

        header("Location: payments.php?msg=added");
    } else {
        header("Location: payments.php?msg=error");
    }
    exit();
}

// 2. UPDATE EXISTING PAYMENT
if (isset($_POST['update_payment'])) {
    $id = (int)$_POST['payment_id'];
    $amount = (float)$_POST['amount'];
    $method = $_POST['method'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE payments SET amount = ?, method = ?, status = ? WHERE id = ?");
    $stmt->bind_param("dssi", $amount, $method, $status, $id);
    
    if($stmt->execute()) {
        header("Location: payments.php?msg=updated");
    } else {
        header("Location: payments.php?msg=error");
    }
    exit();
}

// 3. DELETE PAYMENT
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM payments WHERE id = $id");
    header("Location: payments.php?msg=deleted");
    exit();
}