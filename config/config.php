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
define('MAIL_HOST',     'smtp.gmail.com');
define('MAIL_PORT',     587);
define('MAIL_USERNAME', 'subhan.priv.acc@gmail.com');
define('MAIL_PASSWORD', 'vknp zcvl bmog mynr'); // paste app password here
define('MAIL_FROM',     'subhan.priv.acc@gmail.com');
define('MAIL_NAME',     'Elegance Salon');

/* SESSION START */
/* We start session here so every file that includes config.php has session available */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}