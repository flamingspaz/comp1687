<?php
require_once('helpers.php');
echo $m->render('home',  array('user_details' => isset($_COOKIE['uid_yousef'])));
?>
