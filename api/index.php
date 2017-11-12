<?php
require_once('helpers.php');
$user = array();
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);
}
$error = '';
if (isset($_GET['err'])) {
    switch ($_GET['err']) {
        case 'forbidden':
            $error = "This page does not exist or you are not allowed to access it.";
            break;

        default:
            break;
    }
}
echo $m->render('home',  array('firstname' => $user['firstName'],
                                 'lastname' => $user['lastName'],
                                 'username' => $user['username'],
                                 'profile_photo' => $user['profileImage'],
                                 'user_details' => isset($_COOKIE['uid_yousef']),
                                 'error' => $error));
?>
