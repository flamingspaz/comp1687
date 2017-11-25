<?php

require_once('config.php');
require_once('db.php');
include_once('helpers.php');

if (isset($_COOKIE['uid_yousef'])) {
    header('Location: index.php', true, 302);
}

//$data = json_decode(trim(file_get_contents("php://input")), true);
$data = $_POST;

// only get the password on the initial query to ensure we don't leak any data
$stmt = $link->prepare("SELECT `password` FROM `members` WHERE username = ?");
$stmt->bind_param("s", $data['username']);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_NUM);
if ($row[0] == crypt($data['password'], $row[0])) {
    $stmt = $link->prepare("SELECT `id`, `active` FROM `members` WHERE username = ?");
    $stmt->bind_param("s", $data['username']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    session_start();
    setcookie('uid_yousef', $row['id'], time()+3600, $BASE_URL, $DOMAIN, 0, 0);
    setcookie('username_yousef', $data['username'], time()+3600, $BASE_PATH, $DOMAIN, 0, 0);
    if (!$row['active']) {
        header('Location: pverify.php', true, 302);
    }
    // TODO: make this work
    //header('Location: ' . $data['from'], true, 302);
    header('Location: pprofile.php', true, 302);
    //echo "logged in";
}
else {
    //echo "password incorrect";
    header('Location: plogin.php?error=pwincorrect', true, 302);
}

?>
