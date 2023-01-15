<?php
// if session is not started, start session
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$baseName = "";
$mysql_root_password = "";
$mysql_database = "";
$mysql_username = "";
$mysql_password = "!";
$mysql_host = "";
$mysql_port = "";
?>