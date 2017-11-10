<?php

require_once('config.php');
require_once('db.php');
include_once('helpers.php');

function genPasswordHash($password) {
    $salt = bin2hex(openssl_random_pseudo_bytes(22));
    return crypt($password, '$2y$12$' . $salt);
}

//$data = json_decode(trim(file_get_contents("php://input")), true);
$data = $_POST;
// Validate the data we got
//if(!is_array($data)){
//    return errorResponse('invalid json');
//}

// do things to the password, but override php defaults to use bcrypt
$password = genPasswordHash($data["password"]);

$stmt = $link->prepare("INSERT INTO `members` (email,password,username)
                        VALUES (?, ?, ?)");
$stmt->bind_param("sss", $data["email"], $password, $data["username"]);
$stmt->execute();
// get the ID of the user we just made
$id = mysqli_insert_id($link);

// generate a verification token and store it
$token = rand(10000,99999);
$expiryDate = new DateTime("+24 hours");
$expiryDatef = $expiryDate->format("Y-m-d H:i:s");
$stmt = $link->prepare("INSERT INTO `tokens` (userId,token,expires)
                        VALUES (?, ?, ?)");
$stmt->bind_param("iis", $id, $token, $expiryDatef);
$stmt->execute();

// mail token to user
$to      = $data['email'];
$subject = 'Verify your account';
$message = $m->render('verificationemail', array('token' => $token, 'site' => $BASE_URL));
$headers = "From: $NOTIFICATION_ADDRESS\r\nX-Mailer: PHP/5.6\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";
mail($to, $subject, $message, $headers);

session_start();

/// $_SESSION['session_token'] = bin2hex(random_bytes(32));
setcookie('uid_yousef', $id, time()+3600, "/", $DOMAIN, 0, 0);
// go to verify.php
header('Location: /pverify.php', true, 302);
?>