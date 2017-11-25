<?php
require_once('helpers.php');
require_once('db.php');
checkAuthnAuthz($link);


$cid = $_GET['cid'];
$stmt = $link->prepare("DELETE FROM `commutes` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();

header("Location: pmycommutes.php", true, 302);
?>
