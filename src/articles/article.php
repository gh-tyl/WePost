<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
$postID = $_POST['post_id'];
$dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($connected = $dbSrv->connect()) {
	$joinUsers = $connected->query("SELECT a.id,a.title,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 ORDER BY `id` ASC ");
	$commentsArray = $dbSrv->connect()->query("SELECT `article_id`, `comment`, `datetime` FROM `comment_table`");
	if ($joinUsers) {
		$posts = $joinUsers->fetch_all(MYSQLI_ASSOC);
		$commentsArray = $commentsArray->fetch_all(MYSQLI_ASSOC);

		$resAr = ["post" => "", "comments" => "", "content" => ""];
		$comments = [];
		foreach ($posts as $key => $post) {
			if ($post['id'] == $postID) {
				$resAr["post"] = $post;
				$contPath = "../../data/contents/" . $post["content_path"];
				$file = fopen($contPath, "r");
				$data = fread($file, filesize($contPath));
				fclose($file);
				$resAr["content"] = $data;
			}
		}
		foreach ($commentsArray as $key => $comment) {
			if ($comment['article_id'] == $postID) {
				array_push($comments, $comment);
			}
		}
		$resAr["comments"] = $comments;
		echo json_encode($resAr);
	}
	$dbSrv->close();
} else {
	echo "problem";
}
?>
<?php
// function readThisFile($fileName)
// { //return back an associate array
// 	if (file_exists($fileName)) {
// 		$file = fopen($fileName, 'r');
// 		$dataArray = fread($file, filesize($fileName));
// 		fclose($file);
// 		return $dataArray;
// 	}
// 	return false;
// }

// // INPUTS: article_id
// // OUTPUTS: statusCode, status, data
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
// 	// $article_id = $_POST['article_id'];
// 	$article_id = intval(1);
// 	$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// 	$dbConnected = $db->connect();
// 	if ($dbConnected) {
// 		$article = $dbConnected->query("SELECT a.id,a.title,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 WHERE a.id = $article_id");
// 		$article = $article->fetch_all(MYSQLI_ASSOC);
// 		$db->close();
// 		if ($article) {
// 			$article[0]['content'] = readThisFile($article[0]['content_path']);
// 			$res = array(
// 				"statusCode" => 200,
// 				"status" => "success",
// 				"data" => array(
// 					"article" => $article
// 				)
// 			);
// 			echo json_encode($res);
// 			exit();
// 		} else {
// 			$res = array(
// 				"statusCode" => 204,
// 				"status" => "No Content",
// 				"data" => array(
// 					"article" => []
// 				)
// 			);
// 			echo json_encode($res);
// 			exit();
// 		}
// 	} else {
// 		$res = array(
// 			"statusCode" => 500,
// 			"status" => "Internal Server Error",
// 			"data" => array(
// 				"article" => []
// 			)
// 		);
// 		echo json_encode($res);
// 		exit();
// 	}
// }
?>