<?php
require_once 'includes/db.php'; // Using your existing db connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize data
    $first_name = mysqli_real_escape_class($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_class($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_class($conn, $_POST['email']);
    $phone      = mysqli_real_escape_class($conn, $_POST['phone']);
    $subject    = mysqli_real_escape_class($conn, $_POST['subject']);
    $message    = mysqli_real_escape_class($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        // Redirect back with success message
        header("Location: contact.php?msg=sent");
    } else {
        // Redirect back with error
        header("Location: contact.php?msg=error");
    }
    exit();
}

// Helper function to clean data
function mysqli_real_escape_class($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}