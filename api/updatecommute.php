<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);
$user = $_COOKIE['uid_yousef'];

//$data = json_decode(trim(file_get_contents("php://input")), true);
$data = $_POST;
$id = $data['id'];
// Validate the data we got
//if(!is_array($data)){
//    return errorResponse('invalid json');
//}
$days = ['mon', 'tue', 'wed', 'thu', 'fri'];
$daysSelected = array();

// create an array of days that the user selected
foreach ($days as $day) {
    if ($data['commute' . $day] == 'on') {
        array_push ($daysSelected, $day);
    }
}
$provides = 0;
if ($data['commutetype'] == 'provides') {
    $provides = 1;
}

$stmt = $link->prepare("UPDATE `commutes` SET userId = ?, startPoint = ?, destinationPoint = ?, arriveBy = ?, provides = ?, notes = ?, daysAvailable = ?
                        WHERE id = ?");
$stmt->bind_param("isssissi", $user,
                             trim($data['startloc'], '()'),
                             trim($data['endloc'], '()'),
                             formatTime($data['time']),
                             $provides,
                             $data['notes'],
                             implode(',', $daysSelected),
                             $id);
$stmt->execute();

header("Location: /pcommute.php?id=$id", true, 302);
?>
