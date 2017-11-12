<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);

    echo $m->render('newcommute', array('firstname' => $user['firstName'],
                                     'lastname' => $user['lastName'],
                                     'username' => $user['username'],
                                     'profile_photo' => $user['profileImage'],
                                     'user_details' => isset($_COOKIE['uid_yousef']),
                                     'uid' => $_COOKIE['uid_yousef']));
}
else {
    header('Location: /plogin.php', true, 302);
}

 ?>
