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
// INPUTS: token, title, contents, (genre_id_01, genre_id_02, genre_id_03)
// OUTPUTS: statusCode, status, message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $token = $_POST['token'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $genre_id_01 = $_POST['genre_id_01'];
    $genre_id_02 = $_POST['genre_id_02'];
    $genre_id_03 = $_POST['genre_id_03'];
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnected = $db->connect();
    if ($dbConnected) {
        $user = $dbConnected->query("SELECT `user_id` FROM `user_table` WHERE `token` = '$token'");
        $user = $user->fetch_assoc();
        if ($user) {
            $user_id = $user['user_id'];
            $postInfo = $dbConnected->query("SELECT `post_id`, `content_path` FROM `post_table` WHERE `user_id` = $user_id");
            $postInfo = $postInfo->fetch_assoc();
            if ($postInfo) {
                $post_id = $postInfo['post_id'];
                $content_path = $postInfo['content_path'];
                $dbConnected->query("UPDATE `post_table` SET `title` = '$title', `genre_id_01` = $genre_id_01, `genre_id_02` = $genre_id_02, `genre_id_03` = $genre_id_03 WHERE `post_id` = $post_id");
                $db->close();
                $isEdit = editContent($postInfo, $content);
                if ($isEdit) {
                    echo "
                        {
                            \"statusCode\": 200,
                            \"status\": \"success\",
                            \"message\": \"Post edited successfully\"
                        }
                    ";
                    exit();
                } else {
                    echo "
                        {
                            \"statusCode\": 500,
                            \"status\": \"Internal Server Error\",
                            \"message\": \"Post not edited\"
                        }
                    ";
                    exit();
                }
            } else {
                $db->close();
                echo "
                    {
                        \"statusCode\": 404,
                        \"status\": \"Not Found\",
                        \"message\": \"Post not found\"
                    }
                ";
                exit();
            }
        } else {
            $db->close();
            echo "
                {
                    \"statusCode\": 401,
                    \"status\": \"Unauthorized\",
                    \"message\": \"Invalid token\"
                }
            ";
            exit();
        }
    } else {
        echo "
            {
                \"statusCode\": 500,
                \"status\": \"Internal Server Error\",
                \"message\": \"Database connection failed\"
            }
        ";
        exit();
    }
}
?>