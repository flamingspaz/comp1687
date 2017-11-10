<?php
require_once('helpers.php');

if (!isset($_COOKIE['uid_yousef'])) {
    $username = '';
    if (isset($_COOKIE['username_yousef'])) {
      $username = $_COOKIE['username_yousef'];
    }
    echo $m->render('login',  array('pwincorrect' => isset($_GET['error']),
                                    'user_details' => isset($_COOKIE['uid_yousef']),
                                    'username' => $username));
}
else {
    header('Location: /pprofile.php', true, 302);
}

?>
