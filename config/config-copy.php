<?php
/*  DATABASE CONFIGURATION */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        
define('DB_PASS', '');  
define('DB_NAME', 'saloon');

/* SITE CONFIGURATION */
define('SITE_NAME', 'Elegance Salon');
define('SITE_URL',  'http://localhost/elegance-saloon-management-e-project');

/* EMAIL CONFIGURATION */
define('MAIL_HOST',     '');
define('MAIL_PORT',      '');
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', ''); // app password here
define('MAIL_FROM',     '');
define('MAIL_NAME',     'Elegance Salon');

/* SESSION START */
/* We start session here so every file that includes config.php has session available */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}