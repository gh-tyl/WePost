<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// INPUTS: article_id
// OUTPUTS: statusCode, status, data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// $article_id = $_POST['article_id'];
	$article_id = intval(1);
	$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
	$dbConnected = $db->connect();
	if ($dbConnected) {
		$comments = $dbConnected->query("SELECT `article_id`, `comment`, `datetime` FROM `comment_table` WHERE `article_id` = $article_id");
		$comments = $comments->fetch_all(MYSQLI_ASSOC);
		$db->close();
		if ($comments) {
			echo "
			{
				\"statusCode\": 200,
				\"status\": \"success\",
				\"data\": {
					\"comments\": " . json_encode($comments) . ",
				}
			}";
			exit();
		} else {
			echo "
			{
				\"statusCode\": 204,
				\"status\": \"No Content\",
				\"data\": {
					\"comments\": []
				},
			}";
			exit();
		}
	} else {
		echo "
		{
			\"statusCode\": 500,
			\"status\": \"Internal Server Error\",
			\"data\": {
				\"comments\": []
			},
		}";
		exit();
	}
}
?>