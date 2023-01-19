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
// function writeInFile($fileName, $newData)
// { //write in file new data
//     $file = fopen($fileName, 'w');
//     fwrite($file, $newData);
//     fclose($file);
// }
// // INPUTS: token, title, contents, (genre_id_01, genre_id_02, genre_id_03)
// // OUTPUTS: statusCode, status, message
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     $title = $_POST['title'];
//     $contents = $_POST['contents'];
//     $lastPostID = $db->select('article_table', ['id']); //Have to change the user number to variable
//     $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
//     writeInFile("../../data/contents/post_$lastPostID.txt", $contents);
//     $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
//     $dbConnected = $db->connect();
//     if ($dbConnected) {
//         date_default_timezone_set('America/Vancouver');
//         $date = date('Y-m-d H:i:s');
//         // $user_id = $_SESSION[$_POST['token']['id']];
//         $user_id = 1;
//         $insertCmd = "INSERT INTO article_table (user_id, title, content_path, genre_id_01, likes, stores, datetime) VALUES ($user_id,'$title','post_$lastPostID.txt',0,0,0,'$date')";
//         $isInserted = $dbConnected->query($insertCmd);
//         $dbConnected->close();
//         if ($isInserted === TRUE) {
//             $created = 1;
//             $res = array(
//                 "statusCode" => 200,
//                 "status" => "success",
//                 "message" => "New record created successfully!"
//             );
//             echo json_encode($res);
//             exit();
//         } else {
//             $res = array(
//                 "statusCode" => 500,
//                 "status" => "error",
//                 "message" => "Internal Server Error"
//             );
//             echo json_encode($res);
//             exit();
//         }
//     } else {
//         $res = array(
//             "statusCode" => 500,
//             "status" => "error",
//             "message" => "Internal Server Error"
//         );
//         echo json_encode($res);
//         exit();
//     }
// }
?>