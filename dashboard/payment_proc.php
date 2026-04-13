<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Helper function to notify all management staff
function notifyManagement($conn, $title, $msg, $link) {
    $staff_query = $conn->query("SELECT id FROM users WHERE role IN ('admin', 'receptionist')");
    while($staff = $staff_query->fetch_assoc()) {
        notifyUser($conn, $staff['id'], $title, $msg, "payment", $link);
    }
}

// 1. ADD NEW PAYMENT
if (isset($_POST['process_payment'])) {
    $client_id = (int)$_POST['client_id'];
    $stylist_id = (int)$_POST['stylist_id'];
    $amount = (float)$_POST['amount'];
    $method = $_POST['method'];

    $stmt = $conn->prepare("INSERT INTO payments (client_id, amount, method, status) VALUES (?, ?, ?, 'paid')");
    $stmt->bind_param("ids", $client_id, $amount, $method);
    
    if ($stmt->execute()) {
        $payment_id = $conn->insert_id;

        // Fetch Stylist Commission Rate & Name
        $st_res = $conn->query("SELECT name, commission_rate FROM users WHERE id = $stylist_id");
        $stylist = $st_res->fetch_assoc();
        $comm_amount = ($stylist['commission_rate'] / 100) * $amount;

        // Record Commission
        $comm_stmt = $conn->prepare("INSERT INTO commissions (stylist_id, amount, status) VALUES (?, ?, 'pending')");
        $comm_stmt->bind_param("id", $stylist_id, $comm_amount);
        $comm_stmt->execute();

        // NOTIFICATION LOGIC START 
        
        // 1. Notify Management (Admins/Receptionists)
        $admin_msg = "Payment of Rs. " . number_format($amount) . " received via " . strtoupper($method) . ".";
        notifyManagement($conn, "Revenue Received", $admin_msg, "payments.php");

        // 2. Notify the Stylist about their commission
        $stylist_msg = "You earned Rs. " . number_format($comm_amount) . " commission from a recent service.";
        notifyUser($conn, $stylist_id, "Commission Earned", $stylist_msg, "payment", "commissions.php");

        // 3. Notify the Client (Receipt)
        $client_msg = "Thank you! Your payment of Rs. " . number_format($amount) . " has been confirmed.";
        notifyUser($conn, $client_id, "Payment Receipt", $client_msg, "payment", "index.php");

        // NOTIFICATION LOGIC END

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
        // Notify management of the manual adjustment
        $admin_msg = "Transaction #$id was updated to Rs. " . number_format($amount) . " ($status).";
        notifyManagement($conn, "Payment Updated", $admin_msg, "payments.php");

        header("Location: payments.php?msg=updated");
    } else {
        header("Location: payments.php?msg=error");
    }
    exit();
}

// 3. DELETE PAYMENT
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    
    // Notify management before deleting
    $admin_msg = "Transaction record #$id has been removed from the system.";
    notifyManagement($conn, "Payment Deleted", $admin_msg, "payments.php");

    $conn->query("DELETE FROM payments WHERE id = $id");
    header("Location: payments.php?msg=deleted");
    exit();
}