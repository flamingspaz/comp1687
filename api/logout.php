<?php
    unset($_COOKIE['uid_yousef']);
    session_destroy();
    header('Location: /index.php', true, 302);
?>
