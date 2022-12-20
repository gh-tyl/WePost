<?php
    include '../../config/config.php';
    session_unset();
    session_destroy();
    header("Location: ".$baseName.'pages/user_auth/register.php');
    exit();
?>