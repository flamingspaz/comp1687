<?php
require_once('helpers.php');
require_once('db.php');
//checkAuthnAuthz($link);
header('Content-Type: application/json');
$stmt = $link->prepare("SELECT startPoint,destinationPoint FROM `commutes` WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
$start = explode(', ',$row['startPoint'],2);
$end = explode(', ',$row['destinationPoint'],2);
$data = ['success' => true, 'data' => ['startLat' => $start[0], 'startLng' => $start[1], 'endLat' => $end[0], 'endLng' => $end[1]]];
echo json_encode($data);
?>
