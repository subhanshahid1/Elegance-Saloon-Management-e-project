<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$loggedInId = $_SESSION['user_id'];
$loggedInRole = getUserRole();

// 1. TOGGLE DUTY STATUS
if (isset($_GET['toggle_id'])) {
    $targetId = (int)$_GET['toggle_id'];
    
    // Security: Only Admin OR the user themselves
    if ($loggedInRole === 'admin' || $targetId == $loggedInId) {
        $currentStatus = $_GET['status'];
        $newStatus = ($currentStatus == 'active') ? 'inactive' : 'active';

        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $targetId);
        $stmt->execute();
        header("Location: staff.php?msg=status_updated");
    } else {
        header("Location: staff.php?error=unauthorized");
    }
    exit();
}

// 2. DELETE STAFF (Admin Only)
if (isset($_GET['delete_id']) && $loggedInRole === 'admin') {
    $targetId = (int)$_GET['delete_id'];
    if ($targetId != $loggedInId) { // Prevent self-deletion
        $conn->query("DELETE FROM users WHERE id = $targetId");
        header("Location: staff.php?msg=deleted");
    }
    exit();
}

// 3. ADD STAFF (Admin Only)
if (isset($_POST['add_staff']) && $loggedInRole === 'admin') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $_POST['role'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role, status) VALUES ('$name', '$email', '$pass', '$role', 'active')";
    if ($conn->query($sql)) {
        header("Location: staff.php?msg=added");
    }
    exit();
}