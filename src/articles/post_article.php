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
// INPUTS: token, title, contents, (genre_id_01, genre_id_02, genre_id_03)
// OUTPUTS: statusCode, status, message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $contents = $_POST['contents'];
    $lastPostID = $db->select('article_table', ['id']); //Have to change the user number to variable
    $lastPostID = max($lastPostID->fetch_all(MYSQLI_ASSOC))['id'] + 1; //Find the last postID of user and sum +1 to generate fileName
    writeInFile("../../data/contents/post_$lastPostID.txt", $contents);
    $db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    $dbConnected = $db->connect();
    if ($dbConnected) {
        date_default_timezone_set('America/Vancouver');
        $date = date('Y-m-d H:i:s');
        // $user_id = $_SESSION[$_POST['token']['id']];
        $user_id = 1;
        $insertCmd = "INSERT INTO article_table (user_id, title, content_path, genre_id_01, likes, stores, datetime) VALUES ($user_id,'$title','post_$lastPostID.txt',0,0,0,'$date')";
        $isInserted = $dbConnected->query($insertCmd);
        $dbConnected->close();
        if ($isInserted === TRUE) {
            $created = 1;
            echo "
            {
                \"statusCode\": 200,
                \"status\": \"success\",
                \"message\": \"New record created successfully!\"
            }";
            exit();
        } else {
            echo "
            {
                \"statusCode\": 500,
                \"status\": \"error\",
                \"message\": \"Internal Server Error\"
            }";
            exit();
        }
    } else {
        echo "
        {
            \"statusCode\": 500,
            \"status\": \"error\",
            \"message\": \"Internal Server Error\"
        }";
        exit();
    }
}
?>