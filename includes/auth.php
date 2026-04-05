<?php

/* ===== INCLUDE CONFIG ===== */
require_once __DIR__ . '/../config/config.php';


/* ===== STEP 1 CHECK IF LOGGED IN ===== */
/* This function checks if a user is logged in at all */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}


/* ===== STEP 2 GET CURRENT USER ROLE ===== */
/* Returns the role of whoever is logged in right now */
function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}


/* ===== STEP 3 GET CURRENT USER ID ===== */
/* Returns the ID of whoever is logged in right now */
/* Used for filtering appointments/data by user */
function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}


/* ===== STEP 4 GET CURRENT USER NAME ===== */
function getUserName() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
}


/* ===== STEP 5 MAIN ACCESS CHECK FUNCTION ===== */
/* This is what every dashboard page calls */
/* Pass an array of roles that are allowed on that page */
function checkAccess($allowedRoles = []) {

    /* --- If not logged in at all send to login --- */
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }

    /* --- If logged in but role not allowed send to unauthorized page --- */
    if (!in_array(getUserRole(), $allowedRoles)) {
        header('Location: ' . SITE_URL . '/unauthorized.php');
        exit();
    }

    /* --- If all checks pass allow access --- */
    /* Page continues loading normally */
}