<?php
// MySQL settings
$MYSQL_USERNAME = 'root';
$MYSQL_PASSWORD = 'docker';
$MYSQL_HOST = 'db';
$MYSQL_DB_NAME = 'comp1681';

// Debug mode for better error messages
$DEBUG = true;

// Domain settings
$DOMAIN = 'localhost';
$BASE_PATH = '/';
$BASE_URL = 'http://' . $DOMAIN . $PATH;

// Email
$NOTIFICATION_ADDRESS = 'aa@localhost.localdomain';

// uploads
$MEDIA_DIR = 'media/uploads/';
$PROFILE_PHOTOS_DIR = 'media/profiles/';

date_default_timezone_set('UTC');

if ($DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
?>
