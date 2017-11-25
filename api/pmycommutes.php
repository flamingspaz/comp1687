<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);
}
else {
    header('Location: plogin.php', true, 302);
}

$stmt = $link->prepare("SELECT id,arriveBy,provides,notes,daysAvailable FROM `commutes` WHERE userId = ?");
$stmt->bind_param("i", $_COOKIE['uid_yousef']);
$stmt->execute();
$row = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);



echo $m->render('mycommutes', array('firstname' => $user['firstName'],
'lastname' => $user['lastName'],
'username' => $user['username'],
'profile_photo' => $user['profileImage'],
'user_details' => isset($_COOKIE['uid_yousef']),
'uid' => $_COOKIE['uid_yousef'],
'commutes' => $row
));

?>
