<?php
require_once('helpers.php');
if (!isset($_COOKIE['uid_yousef'])) {
    echo $m->render('register', array('user_details' => isset($_COOKIE['uid_yousef'])));
}
else {
    header('Location: /pprofile.php', true, 302);
}

 ?>
