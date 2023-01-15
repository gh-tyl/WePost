<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
function readThisFile($fileName)
{ //return back an associate array
	if (file_exists($fileName)) {
		$file = fopen($fileName, 'r');
		$dataArray = fread($file, filesize($fileName));
		fclose($file);
		return $dataArray;
	}
	return false;
}

// INPUTS: article_id
// OUTPUTS: article data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// $article_id = $_POST['article_id'];
	$article_id = intval(1);
	$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
	$connected = $db->connect();
	if ($connected) {
		$joinUsers = $connected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 WHERE a.id = $article_id");
		if ($joinUsers) {
			$posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
			echo "
			{
				\"statusCode\": 200,
				\"status\": \"success\",
				\"data\": {
					\"posts\": " . json_encode($posts) . ",
				}
			}";
		} else {
			echo "
			{
				\"statusCode\": 500,
				\"status\": \"error\",
				\"message\": \"Internal Server Error\"
			}";
		}
		$db->close();
	} else {
		echo "
		{
			\"statusCode\": 500,
			\"status\": \"error\",
			\"message\": \"Internal Server Error\"
		}";
	}
}
?>