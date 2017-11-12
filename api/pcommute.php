<?php
require_once('helpers.php');
require_once('db.php');
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);
}

if (!isset($_GET['id'])) {
    header('Location: /index.php', true, 302);
}

$stmt = $link->prepare("SELECT userId,startPoint,destinationPoint,arriveBy,provides,notes,daysAvailable FROM `commutes` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
$provides = 'requesting';
if ($row['provides'] == 1) {
    $provides = 'providing';
}

$stmt = $link->prepare("SELECT id,name FROM `images` WHERE commuteId = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$photosrow = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);
//echo $photosrow[1]['name'];
$commuter = getUserProfile($row['userId'], $link);

echo $m->render('commute', array('firstname' => $user['firstName'],
                                 'lastname' => $user['lastName'],
                                 'username' => $user['username'],
                                 'profile_photo' => $user['profileImage'],
                                 'user_details' => isset($_COOKIE['uid_yousef']),
                                 'uid' => $_COOKIE['uid_yousef'],
                                 'commuteId' => $_GET['id'],
                                 'startpoint' => $row['startPoint'],
                                 'destinationpoint' => $row['destinationPoint'],
                                 'arriveby' => $row['arriveBy'],
                                 'provides' => $provides,
                                 'notes' => $row['notes'],
                                 'days' => $row['daysAvailable'],
                                 'commuter_username' => $commuter['username'],
                                 'commuter_profile_photo' => $commuter['profileImage'],
                                 'commute_photos' => $photosrow

));
 ?>
