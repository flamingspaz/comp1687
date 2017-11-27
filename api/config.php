<?php
// MySQL settings
$MYSQL_USERNAME = 'root';
$MYSQL_PASSWORD = 'docker';
$MYSQL_HOST = 'db';
$MYSQL_DB_NAME = 'comp1681';

// Debug mode for better error messages
$DEBUG = false;

// Domain settings
$DOMAIN = 'localhost';
$BASE_PATH = '/';
$BASE_URL = 'http://' . $DOMAIN . $BASE_PATH;

// Email
$NOTIFICATION_ADDRESS = 'aa@localhost.localdomain';

// uploads
$MEDIA_DIR = 'media/uploads/';
$PROFILE_PHOTOS_DIR = 'media/profiles/';
$MAX_UPLOAD_FILESIZE = 5000000;

// recaptcha
$RECAPTCHA_URL = 'https://www.google.com/recaptcha/api/siteverify';
$RECAPTCHA_SECRET = '6LeYMzgUAAAAAHtlHpJNf72O0B3cRGSjnYUtbW-u';

// Security stuff
$HEADERS = true;
$SECURE_COOKIES = 0;

// Are we running in the crappy stuweb server?
$STUWEB = true;

date_default_timezone_set('UTC');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
if ($HEADERS) {
    // HSTS would force a web browser to use HTTPS, since I don't control the server it's not a good idea to enable this.
    //header("strict-transport-security: max-age=15768000");
    // Only load things from places we know of
    header("Content-Security-Policy: default-src 'none'; connect-src 'self'; font-src https://fonts.gstatic.com https://use.fontawesome.com; img-src 'self' https://csi.gstatic.com https://maps.googleapis.com https://maps.gstatic.com https://mts.googleapis.com; script-src 'self' https://cdnjs.cloudflare.com https://code.jquery.com https://maps.googleapis.com https://maxcdn.bootstrapcdn.com https://use.fontawesome.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://maxcdn.bootstrapcdn.com https://use.fontawesome.com");
    header("X-Content-Type-Options: nosniff");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Frame-Options: DENY");

}
?>
