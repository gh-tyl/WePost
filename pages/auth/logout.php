<?php
session_unset();
session_destroy();
header("Location: ./register.php");
exit();
?>