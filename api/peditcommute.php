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

$stmt = $link->prepare("SELECT userId,arriveBy,provides,notes,daysAvailable,startPoint,destinationPoint FROM `commutes` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
$provides = '';
$requests = 'checked';
$owner = false;
if ($row['userId'] == $_COOKIE['uid_yousef']) {
    $owner = true;
}
if (!$owner) {
    header('Location: /index.php?err=forbidden', true, 302);
}
if ($row['provides'] == 1) {
    $provides = 'checked';
    $requests = '';
}


$days = ['mon', 'tue', 'wed', 'thu', 'fri'];
$daysSelected = array();
foreach ($days as $day) {
    $pos = strpos($row['daysAvailable'], $day);
    if($pos !== false) {
     $daysSelected += array($day => 'checked');
    }
}

$stmt = $link->prepare("SELECT id,name FROM `images` WHERE commuteId = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$photosrow = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);

// Convert the date from mysql-friendly to html5 time friendly
$date = DateTime::createFromFormat('H:i:s', $row['arriveBy']);
$phpdate = $date->format('H:i');

echo $m->render('editcommute', array('firstname' => $user['firstName'],
                                 'lastname' => $user['lastName'],
                                 'username' => $user['username'],
                                 'profile_photo' => $user['profileImage'],
                                 'user_details' => isset($_COOKIE['uid_yousef']),
                                 'uid' => $_COOKIE['uid_yousef'],
                                 'commuteId' => $_GET['id'],
                                 'arriveby' => $phpdate,
                                 'provides' => $provides,
                                 'requests' => $requests,
                                 'startloc' => $row['startPoint'],
                                 'endloc' => $row['destinationPoint'],
                                 'notes' => $row['notes'],
                                 'days' => $row['daysAvailable'],
                                 'commute_photos' => $photosrow,
                                 'owner' => $owner,
                                 'mon' => $daysSelected['mon'],
                                 'tue' => $daysSelected['tue'],
                                 'wed' => $daysSelected['wed'],
                                 'thu' => $daysSelected['thu'],
                                 'fri' => $daysSelected['fri']


));
 ?>
