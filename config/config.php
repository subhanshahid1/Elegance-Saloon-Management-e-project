<?php
/*  DATABASE CONFIGURATION */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        
define('DB_PASS', '');  
define('DB_NAME', 'saloon');

/* SITE CONFIGURATION */
define('SITE_NAME', 'Elegance Salon');
define('SITE_URL',  'http://localhost/elegance-saloon-management-e-project');

/* SESSION START */
/* We start session here so every file that includes config.php has session available */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}