<?php
include "../../config/config.php";
?>
<?php
// INPUT: token
// OUTPUT: statusCode, status, message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$token = $_POST["token"];
	if (isset($_SESSION[$token])) {
		unset($_SESSION[$token]);
		echo "
			{
				\"statusCode\": 200,
				\"status\": \"success\",
				\"message\": \"Logout successful\"
			}
			";
		exit();
	}
	echo "
		{
			\"statusCode\": 401,
			\"status\": \"error\",
			\"message\": \"Invalid token\"
		}
		";
	exit();
	// session_destroy();
	// session_unset();
	// exit();
}
?>