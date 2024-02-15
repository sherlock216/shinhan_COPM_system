<?php
session_start();

unset($_SESSION['user_login']);


session_unset();
session_destroy();


header("Location: login.html");
exit;
?>