<?php
require_once 'includes/db.php';
require_once 'includes/auth.php'; // Required for notifications

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize data
    $first_name = sanitize_input($conn, $_POST['first_name']);
    $last_name  = sanitize_input($conn, $_POST['last_name']);
    $email      = sanitize_input($conn, $_POST['email']);
    $phone      = sanitize_input($conn, $_POST['phone']);
    $subject    = sanitize_input($conn, $_POST['subject']);
    $message    = sanitize_input($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        // NOTIFICATION LOGIC START
        $notif_title = "New Client Message";
        $notif_msg = "New inquiry from $first_name $last_name regarding $subject";
        $notif_link = "messages.php"; // The page we created in the previous step

        // Notify all Admins
        notifyRole($conn, 'admin', $notif_title, $notif_msg, 'message', $notif_link);

        // Notify all Receptionists
        notifyRole($conn, 'receptionist', $notif_title, $notif_msg, 'message', $notif_link);
        // NOTIFICATION LOGIC END

        header("Location: contact.php?msg=sent");
    } else {
        header("Location: contact.php?msg=error");
    }
    exit();
}

// Fixed helper function name to be more standard
function sanitize_input($conn, $data)
{
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}
