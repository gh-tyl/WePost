<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
function writeInFile($fileName, $newData)
{ //write in file new data
    $file = fopen($fileName, 'w');
    fwrite($file, $newData);
    fclose($file);
}
function editContent($postInfo, $content)
{
    $content_path = $postInfo['content_path'];
    $content_path = "../../" . $content_path;
    writeInFile($content_path, $content);
    return true;
}
if (isset($_GET['id'])) {
    $pID = intval($_GET['id']);
    $dbSrv = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    if ($connected = $dbSrv->connect()) {
        $result = $connected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 WHERE a.id=$pID");
        if ($result) {
            $postInfo = $result->fetch_assoc();
            $contentText = readThisFile("../../data/contents/" . $postInfo['content_path']);
            $date = new DateTimeImmutable($postInfo['datetime']);
            $date = $date->format('l jS \o\f F Y h:i A');
            $fullname = $postInfo['first_name'] . " " . $postInfo['last_name'];
        }
        $dbSrv->close();
    } else {
        $res = array(
            "statusCode" => 500,
            "status" => "error",
            "message" => "Database connection failed"
        );
        echo json_encode($res);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $newContent = $_POST['newContent'];
    $filename = "../../data/contents/" . $_POST['path'];
    writeInFile($filename, $newContent);
    $_SESSION['newContent'] = $newContent;
    $_SESSION['edited'] = 1;
    $res = array(
        "statusCode" => 200,
        "status" => "success",
        "message" => "Post edited successfully"
    );
    echo json_encode($res);
    exit();
}

// // INPUTS: token, title, contents, (genre_id_01, genre_id_02, genre_id_03)
// // OUTPUTS: statusCode, status, message
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     $token = $_POST['token'];
//     $user_id = $_SESSION[$token]['id'];
//     $title = $_POST['title'];
//     $content = $_POST['content'];
//     $genre_id_01 = $_POST['genre_id_01'];
//     $genre_id_02 = $_POST['genre_id_02'];
//     $genre_id_03 = $_POST['genre_id_03'];
//     $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
//     $dbConnected = $db->connect();
//     if ($dbConnected) {
//         $postInfo = $dbConnected->query("SELECT `post_id`, `content_path` FROM `post_table` WHERE `user_id` = $user_id");
//         $postInfo = $postInfo->fetch_assoc();
//         if ($postInfo) {
//             $post_id = $postInfo['post_id'];
//             $content_path = $postInfo['content_path'];
//             $dbConnected->query("UPDATE `post_table` SET `title` = '$title', `genre_id_01` = $genre_id_01, `genre_id_02` = $genre_id_02, `genre_id_03` = $genre_id_03 WHERE `post_id` = $post_id");
//             $db->close();
//             $isEdit = editContent($postInfo, $content);
//             if ($isEdit) {
//                 $res = array(
//                     "statusCode" => 200,
//                     "status" => "success",
//                     "message" => "Post edited successfully"
//                 );
//                 echo json_encode($res);
//                 exit();
//             } else {
//                 $res = array(
//                     "statusCode" => 500,
//                     "status" => "error",
//                     "message" => "Post not edited"
//                 );
//                 echo json_encode($res);
//                 exit();
//             }
//         } else {
//             $db->close();
//             $res = array(
//                 "statusCode" => 404,
//                 "status" => "error",
//                 "message" => "Post not found"
//             );
//             echo json_encode($res);
//             exit();
//         }
//     } else {
//         $res = array(
//             "statusCode" => 500,
//             "status" => "error",
//             "message" => "Database connection failed"
//         );
//         echo json_encode($res);
//         exit();
//     }
// }
?>