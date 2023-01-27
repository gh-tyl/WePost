<?php
include "../../config/config.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUT: token
// OUTPUT: statusCode, status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$token = $_POST["token"];
	session_id($token);
	session_start();
	if ($_SESSION['logUser']) {
		unset($_SESSION['logUser']);
		$res = array(
			'statusCode' => 200,
			'status' => 'success',
			'message' => 'Logout successful'
		);
		echo json_encode($res);
		exit();
	}
	$res = array(
		'statusCode' => 401,
		'status' => 'error',
		'message' => 'Invalid token'
	);
	echo json_encode($res);
	exit();
	// session_destroy();
	// session_unset();
	// exit();
}
?>