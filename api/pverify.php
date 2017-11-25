<?php
require_once('helpers.php');
if (isset($_COOKIE['uid_yousef'])) {
    echo $m->render('verify', array('user_details' => isset($_COOKIE['uid_yousef']),
                                    'vcincorrect' => isset($_GET['error'])));
}
else {
    header('Location: pregister.php', true, 302);
}
 ?>
