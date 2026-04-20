<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

// ACTION: UPDATE PROFILE
if ($action === 'update_profile') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$user_id'";
    if ($conn->query($sql)) {
        $_SESSION['user_name'] = $name; 
        header("Location: settings.php?success=Profile updated successfully");
    } else {
        header("Location: settings.php?error=Failed to update profile");
    }
}

// ACTION: UPDATE PASSWORD
if ($action === 'update_password') {
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($new_pass !== $confirm_pass) {
        header("Location: settings.php?error=Passwords do not match");
        exit;
    }

    $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hashed_pass' WHERE id = '$user_id'";
    
    if ($conn->query($sql)) {
        header("Location: settings.php?success=Password updated successfully");
    } else {
        header("Location: settings.php?error=Security update failed");
    }
}

// ACTION: ADMIN GLOBAL SETTINGS
if ($action === 'update_salon' && getUserRole() === 'admin') {
    foreach ($_POST as $key => $value) {
        if ($key == 'action') continue;
        $val = mysqli_real_escape_string($conn, $value);
        // Uses the salon_settings table from your SQL
        $conn->query("INSERT INTO salon_settings (setting_key, setting_value) 
                      VALUES ('$key', '$val') 
                      ON DUPLICATE KEY UPDATE setting_value = '$val'");
    }
    header("Location: settings.php?success=Salon configuration saved");
}