<?php

/* INCLUDE CONFIG */
/* We need config.php because DB constants are defined there */
require_once '../config/config.php';

/* DATABASE CONNECTION */
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/* CONNECTION CHECK */
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}