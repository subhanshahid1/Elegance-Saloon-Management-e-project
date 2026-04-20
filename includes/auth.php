<?php

/* Include configuration for SITE_URL and other constants */
require_once __DIR__ . '/../config/config.php';

/* Authentication functions for session management */

// Check if a session is active and a user ID is set
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Get the current user role from session
function getUserRole()
{
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

// Get the current user ID for database filtering
function getUserId()
{
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Get the display name of the logged in user
function getUserName()
{
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
}

// Protect pages by checking if user role is in the allowed array
function checkAccess($allowedRoles = [])
{

    // Redirect to login if no active session
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }

    // Redirect if user role does not have permission for this specific page
    if (!empty($allowedRoles) && !in_array(getUserRole(), $allowedRoles)) {
        header('Location: ' . SITE_URL . '/unauthorized.php');
        exit();
    }
}

/* Creates a notification for a specific user. */
function notifyUser($conn, $user_id, $title, $message, $type = 'general', $link = 'index.php')
{
    // Prevent duplicate notifications for the same event
    $check = $conn->prepare("SELECT id FROM notifications WHERE user_id = ? AND message = ? AND is_read = 0");
    $check->bind_param("is", $user_id, $message);
    $check->execute();
    if ($check->get_result()->num_rows > 0) return;

    $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message, type, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $title, $message, $type, $link);
    return $stmt->execute();
}

/**
 * NEW FUNCTION: Notify by Role
 * Sends a notification to all users matching a specific role.
 * This does not impact existing notifyUser calls.
 */
function notifyRole($conn, $role, $title, $message, $type = 'general', $link = 'index.php')
{
    $stmt = $conn->prepare("SELECT id FROM users WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        notifyUser($conn, $row['id'], $title, $message, $type, $link);
    }
}
