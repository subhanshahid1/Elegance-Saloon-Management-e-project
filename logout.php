<?php

/* ===== INCLUDE CONFIG ===== */
require_once 'config/config.php';

/* ===== DESTROY SESSION ===== */

// Step 1 Start the session so we can access it
session_start();

// Step 2 Clear all session variables
session_unset();

// Step 3 Completely destroy the session
session_destroy();

// Step 4 Redirect to login page
header('Location: ' . SITE_URL );
exit();
?>