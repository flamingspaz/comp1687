<?php
    require_once('config.php');
    setcookie('uid_yousef' , '' , time() - 3600, $BASE_PATH, $DOMAIN, $SECURE_COOKIES, $SECURE_COOKIES);
    //session_destroy();
    header('Location: index.php', true, 302);
?>
