<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);
}

if (!isset($_GET['id'])) {
    header('Location: /index.php', true, 302);
}

$stmt = $link->prepare("SELECT userId,arriveBy,provides,notes,daysAvailable FROM `commutes` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
$provides = 'requesting';
$owner = false;
if ($row['provides'] == 1) {
    $provides = 'providing';
}
if ($row['userId'] == $_COOKIE['uid_yousef']) {
    $owner = true;
}
if (!$owner) {
    header('Location: /index.php?err=forbidden', true, 302);
}
$stmt = $link->prepare("SELECT id,name FROM `images` WHERE commuteId = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$photosrow = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);

echo $m->render('editcommute', array('firstname' => $user['firstName'],
                                 'lastname' => $user['lastName'],
                                 'username' => $user['username'],
                                 'profile_photo' => $user['profileImage'],
                                 'user_details' => isset($_COOKIE['uid_yousef']),
                                 'uid' => $_COOKIE['uid_yousef'],
                                 'commuteId' => $_GET['id'],
                                 'arriveby' => $row['arriveBy'],
                                 'provides' => $provides,
                                 'notes' => $row['notes'],
                                 'days' => $row['daysAvailable'],
                                 'commute_photos' => $photosrow,
                                 'owner' => $owner

));
 ?>
