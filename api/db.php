<?php
require_once('config.php');
include_once('helpers.php');

$link = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DB_NAME) or
die(errorResponse('Failed to connect to MySQL server. ' . mysqli_connect_error()));
?>
