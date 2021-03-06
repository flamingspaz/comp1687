<?php
require_once('helpers.php');
require_once('db.php');
if (isset($_COOKIE['uid_yousef'])) {
    $user = getUserProfile($_COOKIE['uid_yousef'], $link);
}


if ($STUWEB) {
    // Fall back to crappy SQL if we're running in stuweb
    $query = '%' . $_GET['text'] . '%';
    $stmt = $link->prepare("SELECT *
    FROM `commutes`
    WHERE `notes`
    LIKE ?");
    $stmt->bind_param("s", $query);
}
else {
    $stmt = $link->prepare("SELECT *
    FROM `commutes`
    WHERE MATCH(notes) AGAINST(?)
    ORDER BY MATCH(notes) AGAINST(?) DESC");
    $stmt->bind_param("ss", $_GET['text'], $_GET['text']);
}

$stmt->execute();
$row = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);
setcookie('psearch_yousef', $_GET['text'], time()+3600, $BASE_PATH, $DOMAIN, $SECURE_COOKIES, $SECURE_COOKIES);

echo $m->render('search', array('firstname' => $user['firstName'],
                                 'lastname' => $user['lastName'],
                                 'username' => $user['username'],
                                 'profile_photo' => $user['profileImage'],
                                 'user_details' => isset($_COOKIE['uid_yousef']),
                                 'uid' => $_COOKIE['uid_yousef'],
                                 'results' => $row,
                                 'query' => $_GET['text']

));
 ?>
