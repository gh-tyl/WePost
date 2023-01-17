<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
// get the data from the database
$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
$connected = $db->connect();
if ($connected) {
	$usersCount = $db->select('user_table', ['id'], "user_table.role='user'");
	$articleInfo = $db->select('article_table', ['id', 'user_id', 'likes', 'stores', 'datetime']);
	$likesSel = $db->select('article_table', ['id', 'user_id', 'likes']);
	$likesSearch = $connected->query("SELECT a.id,a.likes,a.stores,a.datetime,u.first_name,u.last_name FROM article_table a INNER JOIN user_table u ON u.id = a.user_id");
	$likesSearch = $likesSearch->fetch_all(MYSQLI_ASSOC);
	$likesSel = $likesSel->fetch_all(MYSQLI_ASSOC);
	$db->close();
	$ranking_articles = [];
	foreach ($likesSel as $post) {
		$ranking_articles[$post['id']] = 0;
	}
	foreach ($likesSel as $post) {
		$ranking_articles[$post['id']] += $post['likes'];
	}
	// echo ("<pre>");
	// print_r($ranking_articles);
	// echo ("</pre>");
	arsort($ranking_articles);
	$ranking_articles = array_slice($ranking_articles, 0, 5, true);

	$ranking_users = [];
	foreach ($likesSel as $post) {
		$ranking_users[$post['user_id']] = 0;
	}
	foreach ($likesSel as $post) {
		$ranking_users[$post['user_id']] += $post['likes'];
	}
	// echo ("<pre>");
	// print_r($ranking_users);
	// echo ("</pre>");
	arsort($ranking_users);
	$ranking_users = array_slice($ranking_users, 0, 5, true);
	$res = array(
		"statusCode" => 200,
		"status" => "success",
		"usersCount" => $usersCount->num_rows,
		"articlesCount" => $articleInfo->num_rows,
		"ranking_articles" => $ranking_articles,
		"ranking_users" => $ranking_users
	);
	echo json_encode($res);
	exit();
} else {
	$res = array(
		"statusCode" => 500,
		"status" => "Internal Server Error",
		"usersCount" => 0,
		"articlesCount" => 0,
		"ranking_articles" => [],
		"ranking_users" => []
	);
	echo json_encode($res);
	exit();
}
?>