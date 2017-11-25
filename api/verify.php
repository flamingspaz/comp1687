<?php
/*

{
  "token": "12345"
}

*/
require_once('config.php');
require_once('db.php');
include_once('helpers.php');

//$data = json_decode(trim(file_get_contents("php://input")), true);
$data = $_POST;
$message = '';
// Validate the data we got
//if(!is_array($data)){
//    return errorResponse('invalid json');
//}
$user = $_COOKIE['uid_yousef'];
// TODO: check if user has already been verified, if so 302 to profile
$stmt = $link->prepare("SELECT `token` FROM `tokens` WHERE userId = ?");
$stmt->bind_param("i", $user);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_NUM);

if ($row[0] == $data['token']) {
    $verified = true;
}
else {
    $verified = false;
}

if ($verified) {
    $stmt = $link->prepare("UPDATE `members` SET active=1 WHERE id = ?");
    $stmt->bind_param("i", $user);
    $stmt->execute();

    $stmt = $link->prepare("DELETE FROM `tokens` WHERE userId = ?");
    $stmt->bind_param("i", $user);
    $stmt->execute();
}
//header('Content-Type: application/json');
//echo "{\"success\": \"$verified\", \"message\":\"$message\"}";

if ($verified) {
    header("Location: /pprofile.php", true, 302);
}
else {
    header("Location: /pverify.php?error=vcincorrect", true, 302);
}

?>
