<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);


$cid = $_GET['cid'];
$stmt = $link->prepare("DELETE FROM `images` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();

header("Location: peditcommute.php?id=$cid", true, 302);
?>
