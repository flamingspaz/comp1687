<?php
include_once('config.php');
include_once('db.php');

require_once('vendor/autoload.php');
$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates'),
));

function checkAuthnAuthz($link) {
// Checks if the user is authenticated otherwise redirects them to the login page
// Checks if the user is authorized otherwise redirects them to the verification page
    if (!isset($_COOKIE['uid_yousef'])) {
      header('Location: /plogin.php?error=forbidden', true, 302);
    }
    $stmt = $link->prepare("SELECT `active` FROM `members` WHERE id = ?");
    $stmt->bind_param("i", $_COOKIE['uid_yousef']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_array(MYSQLI_NUM);
    if ($row[0]) {
        return true;
    }
    else {
        header('Location: /pverify.php', true, 302);
    }
}

function getUserProfile($uid, $link) {
// Grab user info for the header
  $stmt = $link->prepare("SELECT `firstName`, `lastName`, `username`, `profileImage` FROM `members` WHERE id = ?");
  $stmt->bind_param("s", $uid);
  $stmt->execute();
  return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
}

function formatTime($time) {
// Puts times from html forms into a MySQL time friendly format
    $date = DateTime::createFromFormat('H:i', $time);
    return $date->format('H:i:s');
}

?>
