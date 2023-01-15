<?php
include("../../config/config.php");
include("../../services/db.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Header: *');
header('Content-Type: application/json');
?>
<?php
if (isset($_GET['id'])) {
    $pID = intval($_GET['id']);
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $connected = $db->connect();
    if ($connected) {
        $result = $connected->query("SELECT a.id,a.content_path,a.genre_id_01,a.genre_id_02,a.genre_id_03,a.likes,a.stores,a.datetime,u.first_name,u.last_name,u.email,g.genre FROM article_table a INNER JOIN user_table u ON u.id = a.user_id INNER JOIN genre_table g ON g.id = a.genre_id_01 WHERE a.id=$pID");
        if ($result) {
            $postInfo = $result->fetch_assoc();
            $contentText = readThisFile("../../data/contents/" . $postInfo['content_path']);
            $date = new DateTimeImmutable($postInfo['datetime']);
            $date = $date->format('l jS \o\f F Y h:i A');
            $fullname = $postInfo['first_name'] . " " . $postInfo['last_name'];
            echo "
                {
                    \"statusCode\": 200,
                    \"status\": \"success\",
                    \"data\": {
                        \"postInfo\": {
                            \"id\": " . $postInfo['id'] . ",
                            \"content_path\": \"" . $postInfo['content_path'] . "\",
                            \"genre_id_01\": " . $postInfo['genre_id_01'] . ",
                            \"genre_id_02\": " . $postInfo['genre_id_02'] . ",
                            \"genre_id_03\": " . $postInfo['genre_id_03'] . ",
                            \"likes\": " . $postInfo['likes'] . ",
                            \"stores\": " . $postInfo['stores'] . ",
                            \"datetime\": \"" . $date . "\",
                            \"first_name\": \"" . $postInfo['first_name'] . "\",
                            \"last_name\": \"" . $postInfo['last_name'] . "\",
                            \"email\": \"" . $postInfo['email'] . "\",
                            \"genre\": \"" . $postInfo['genre'] . "\"
                        },
                        \"contentText\": \"" . $contentText . "\"
                    }
                }";
        }
        $db->close();
    } else {
        echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal Server Error\"
            }
        ";
    }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = $_POST['data'];
    $newContent = $data['contentText'];
    $filename = "../../data/contents/" . $postInfo['content_path'];
    writeInFile($filename, $newContent);
    $_SESSION['newContent'] = $newContent;
    $_SESSION['edited'] = 1;
    echo "
        {
            \"statusCode\": 200,
            \"status\": \"success\",
            \"message\": \"Content edited successfully\"
        }
    ";
}
?>