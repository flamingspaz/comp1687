<?php
    require_once('config.php');
    setcookie('uid_yousef' , '' , time() - 3600, $BASE_PATH, $DOMAIN, 0, 0);
    //session_destroy();
    header('Location: index.php', true, 302);
?>
