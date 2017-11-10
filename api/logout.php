<?php
    setcookie('uid_yousef' , '' , time() - 3600);
    //session_destroy();
    header('Location: /index.php', true, 302);
?>
